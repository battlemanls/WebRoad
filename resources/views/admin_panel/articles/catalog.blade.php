@extends('layouts.admin')
<link rel="stylesheet" href="{{asset('css/admin_panel/pages/catalog.css')}}">




@section('content')
    <div class="wrap_content">
        <h2>Список публикаций</h2>


        <div class="search_block">
            <form class="search_form" name="search_form" method="post" action={{route('admin_panel.articles.catalog.search')}}>
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
                            <option value='Новости'>Новини</option>
                            <option value='Анонсы'>Анонси</option>
                        <!--    <option value='Стан доріг'>Стан доріг</option> -->
                            <option value='Скоро опубликуются'>Очікують публікацію</option>
                            <option value='Временные (уже скрытые)'>Тимчасові (вже недоступні)</option>
                            <option value='Скрытые'>Приховані</option>
                    </select>
                </div>

                <div>
                    <label>Пошук:</label>
                </div>
                <div>
                    @if (session('error'))
                        <div class="alert-danger">{{ session('error') }}</div>
                    @endif


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
                <div>Назва</div>
                <div>Дата додання</div>
                <div>Тип</div>
                <div>Дата публікації</div>
                <div>Видимий</div>
            </div>

        @if(isset($data))
            @foreach($data as $d)

                    <div class="wrap_page_nth">
                    <div class="pages_nth">
                        <div>{{$d->title}}</div>
                        <div class="date_add">{{$d->created_at}}</div>
                        <div class="type">{{$d->type_articlesss->name}}</div>
                        <div class="date_public">@if(isset($d->date_advice))
                            {{$d->date_advice}}
                                 @else
                                {{$d->created_at}}
                                 @endif
                        </div>
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
                            <a href="{{route('articles.show',[$d->id])}}"><button class ='save'><span>Відкрити</span></button></a>
                            <a href="{{route('admin_panel.articles.edit',[$d->id])}}"><button class ='edit'><span>Редагувати</span></button></a>
                            <form method = 'post' action="{{ route('admin_panel.articles.delete', $d->id ) }}" >
                                @csrf
                                {{method_field('DELETE')}}
                                <button class='delete' type="submit"><span>Видалити</span></button>
                            </form>
                        </div>
                    </div>


                @endforeach
                    {{$data->links()}}
            @endif



    </div>
    </div>













@endsection
