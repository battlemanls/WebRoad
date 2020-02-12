@extends('layouts.admin')

<link rel="stylesheet" href="{{asset('css/admin_panel/create.css')}}">

@section('content')
    <div class="wrap_content">
        @if(isset($data->title))
            <h2>Редагування карти</h2>
        @else
            <h2>Додання карти</h2>
        @endif

        <div class="wrap_block">
            <form id='my_form' name="my_form" action="{{route('admin_panel.maps.store')}}"  method="post">
                @csrf
                <div>
                    <label>Назва:</label>
                    <div>
                        @if($errors->get('title')!=null)
                            <label class="alert-danger_mini">{{$errors->get('title')[0]}}</label>
                        @endif
                    @if(isset($data->title))
                        <input maxlength="191" placeholder="Назва метеріалу" name = 'title' value="{{$data->title}}">
                        @else
                        <input maxlength="191" placeholder="Назва метеріалу" name = 'title'>
                    @endif
                    </div>
                </div>

                <div>
                    <label>URL (src): </label>
                    <div>
                        <img src="{{asset("/storage/manual/map.JPG")}}" style="max-width: 90%;">
                        @if(isset($data->url))
                            <input placeholder="https://www.google.com/maps/d/u/0/embed?mid=1EkiBWGao1tZYFSTDxU9hWBx10bFHFnZF" type="url" name="url" value="{{$data->url}}">
                        @else
                            <input placeholder="https://www.google.com/maps/d/u/0/embed?mid=1EkiBWGao1tZYFSTDxU9hWBx10bFHFnZF" type="urk" name="url">
                        @endif
                    </div>
                </div>

            <!-- Скрытые поля -->
                @if(isset($data))
                    <input name="edit" value="edit" hidden>
                    <input name="id" value="{{$data->id}}" hidden>
                    @endif
            </form>

            <div class="block_submit">
                <button form="my_form" class="button_submit" type="submit">ок</button>
            </div>
        </div>
    </div>

   <!-- Скрипты страницы -->

@endsection