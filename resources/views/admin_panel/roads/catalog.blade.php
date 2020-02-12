@extends('layouts.admin')
<link rel="stylesheet" href="{{asset('css/admin_panel/pages/catalog.css')}}">

@section('content')
    <div class="wrap_content">
        <h2>Дороги</h2>
        <div class="search_block">
            <form class="search_form" name="search_form" method="post" action={{route('admin_panel.roads.catalog.search')}}>
                @csrf
                <div>
                    <label>Тип дороги:</label>
                </div>
                <div>
                    <select name="type_search">
                        @if(isset($type_search))
                            <option selected value="{{$type_search}}">Обрано: {{$type_search}}</option>
                            <option value='Все'>Всі (загальнодоступні)</option>
                        @else
                            <option selected value='Все'>Всі (загальнодоступні)</option>
                        @endif
                            @foreach($types as $t)
                                <option value='{{$t->name}}'>{{$t->name}}</option>
                            @endforeach
                    </select>
                </div>
                <div>
                    <label>Регіон:</label>
                </div>
                <div>
                    <select name="type_search_region">
                        @if(isset($type_search_region))
                            <option selected value="{{$type_search_region}}">Обрано: {{$type_search_region}}</option>
                            <option value='Все'>Всі (загальнодоступні)</option>
                        @else
                            <option selected value='Все'>Всі (загальнодоступні)</option>
                        @endif
                        @foreach($regions as $r)
                        <option value='{{$r->name}}'>{{$r->name}}</option>
                            @endforeach
                    </select>
                </div>
                <div><button type="submit">Знайти</button></div>
            </form>
        </div>

        <div class="wrap_pages">
            <div class="pages_nth">
                <div><b>Назва</b></div>
                <div><b>Регион: </b></div>
                <div><b>Тип: </b></div>
            </div>

        @if(isset($data))
            @foreach($data as $d)
                <div class="wrap_page_nth">
                    <div class="pages_nth">
                        <div>@if(isset($d->title))
                                {{$d->title}}
                                 @else
                                @if(isset($d->regions->id) && isset($d->type_roads->id))
                                    Дорога {{$d->regions->name}} - {{$d->type_roads->name}}
                                    @endif
                            @endif</div>
                        <div class="region">@if(isset($d->regions->id))
                                {{$d->regions->name}}
                            @endif
                        </div>
                        <div class="type">@if(isset($d->type_roads->id))
                                {{$d->type_roads->name}}
                            @endif
                        </div>
                    </div>

                    <div class="control_page">
                        <a href="{{route('admin_panel.roads.show',[$d->id])}}"><button class="save"><span>Відкрити</span></button></a>
                        <a href="{{route('admin_panel.roads.edit',[$d->id])}}"><button class="edit"><span>Редагувати</span></button></a>
                  <!--      <form method = 'post' action="{{ route('admin_panel.roads.delete', $d->id ) }}" >
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
