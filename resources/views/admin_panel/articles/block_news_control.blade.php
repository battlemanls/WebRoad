@extends('layouts.admin')
<link rel="stylesheet" href="{{asset('css/admin_panel/pages/catalog.css')}}">

@section('content')
    <div class="wrap_content">
        <h2>Сторінка настройки відображення новин</h2>
        <div class="wrap_pages">
            <h2>Настройка порядка відображення новин</h2>
            <div class="pages_nth">
                <div><b>Назва</b></div>
                <div><b>Дата публікації</b></div>
                <div><b>Позиция: </b></div>
            </div>

        <div class="wrap_page_nth" title="t_p">
            <div style="display: none" class="alert-danger"></div>
                @include('admin_panel\articles\block_news_control__table_position')
        </div>
    </div>

    <div class="wrap_content">
        <h2>Выбор новостей, которые будут отображаться на главной</h2>
    <div class="search_block">
            <form class="search_form" name="search_form" method="post" action={{route('admin_panel.blocknews.search')}}>
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
                            <option selected value='Все'>Всі</option>
                        @endif
                        <option value='Скоро опубликуются'>Очікують публікацію</option>
                        <option value='Временные (уже скрытые)'>Тимчасові (вже недоступні)</option>
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
                <div><b>Дата додання</b></div>
                <div><b>Тип: </b></div>
                <div><b>Дата публікації</b></div>
                <div><b>Видимий </b></div>
            </div>

        <div class="wrap_page_nth" title="t_a">
            <div style="display: none" class="alert-danger"></div>
                @include('admin_panel\articles\block_news_control__table_article')
        </div>
    </div>
    </div>

    @include('js_blade.js_block_news_control')
    </div>

@endsection
