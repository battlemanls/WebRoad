@extends('layouts.admin')
<link rel="stylesheet" href="{{asset('css/admin_panel/pages/catalog.css')}}">

@section('content')
    <div class="wrap_content">
        <h2>Список страниц</h2>
        <div class="search_block">
            <form class="search_form" name="search_form" method="post" action={{route('admin_panel.pages.catalog.search')}}>
                @csrf
                <div>
                    <label>Показати статті: </label>
                </div>
                <div>
                    <select name="type_search">
                        @if(isset($type_search))
                            <option selected value="{{$type_search}}">Обрано: {{$type_search}}</option>
                            <option value='Все'>Всі (загальнодоступні)</option>
                        @else
                            <option selected value='Все'>Всі (загальнодоступні)</option>
                        @endif
                        <option value='Скрытые'>Приховані</option>
                    </select>
                </div>

                <div>
                    <label>Пошук:</label>
                </div>
                <div>
                    @if(isset($title_search))
                        <input type="text" value="{{$title_search}}"  name = 'title_search'>
                    @else
                        <input type="text"  name = 'title_search'>
                    @endif
                </div>
                <div><button type="submit">Знайти</button></div>
            </form>
        </div>

        <div class="wrap_pages">
            <div class="pages_nth">
                <div><b>Назва</b></div>
                <div><b>Видимий</b></div>
            </div>

        @if(isset($data))
            @foreach($data as $d)

                <div class="wrap_page_nth">
                    <div class="pages_nth">
                        <div>{{$d->title}}</div>
                        <div class="visible">@if(isset($d->status))
                                @if($d->status==true)
                                    Да
                                @else
                                    Нет
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="control_page">
                        <a href="{{route('web.pages.show',[$d->id])}}"><button class="save"><span>Відкрити</span></button></a>
                        <a href="{{route('admin_panel.pages.edit',[$d->id])}}"><button class="edit"><span>Редагувати</span></button></a>
                     <!--   <form method = 'post' action="{{ route('admin_panel.pages.delete', $d->id ) }}" >
                            @csrf
                            {{method_field('DELETE')}}
                            <div><button type="submit" >Видалити</button></div>
                        </form> -->
                    </div>

                </div>
            @endforeach
            {{$data->links()}}
        @endif
        </div>
    </div>

@endsection
