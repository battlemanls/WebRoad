@extends('layouts.admin')

<link rel="stylesheet" href="{{asset('css/admin_panel/create.css')}}">

@section('content')
    <div class="wrap_content">
        @if(isset($data->title))
            <h2>Редагування інформації</h2>
        @else
            <h2>Додання нової інформації</h2>
        @endif

        <div class="wrap_block">

            <form id='my_form' name="my_form" action="{{route('admin_panel.roads.store')}}" enctype="multipart/form-data" method="post">
                @csrf
                <div>
                    <label>Назва:</label>
                    <div>
                    @if(isset($data->title))
                        <input maxlength="191" placeholder="не обов'язково" name = 'title' value="{{$data->title}}">
                        @else
                        <input maxlength="191" placeholder="не обов'язково" name = 'title'>
                    @endif
                    </div>
                </div>

                <div>
                    <label>Тип дороги: </label>
                    <div>
                        @if(isset($data->id_type))
                            <select id="id_type" name="id_type">
                                <option selected value="{{$data->id_type}}">Обрано: {{$data->type_roads->name}}</option>
                                @foreach($type as $t)
                                    <option value="{{$t->id}}">{{$t->name}}</option>
                                @endforeach
                            </select>
                        @else
                            <select id="id_type" name="id_type">
                                @foreach($type as $t)
                                    <option value="{{$t->id}}">{{$t->name}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>

                <div>
                    <label>Регион: </label>
                    <div>
                        @if(isset($data->id_region))
                            <select id="id_region" name="id_region">
                                <option selected value="{{$data->id_region}}">Обрано: {{$data->regions->name}}</option>
                                @foreach($region as $t)
                                    <option value="{{$t->id}}">{{$t->name}}</option>
                                @endforeach
                            </select>
                        @else
                            <select id="id_region" name="id_region">
                                @foreach($region as $t)
                                    <option value="{{$t->id}}">{{$t->name}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>

                <div>
                    <label>Контент сторінки:</label>
                    <div>
                    @if(isset($data->body))
                        <textarea name="body" id="editor-body_2">{{$data->body}}</textarea>
                    @else
                        <textarea name="body" id="editor-body_2"></textarea>
                    @endif
                    </div>
                </div>

                <div>
                    <label>Мета опис (meta_description): </label>
                    <div>
                    @if(isset($data->meta_description))
                        <input placeholder="дорога" name="meta_description" value="{{$data->meta_description}}">
                    @else
                        <input placeholder="дорога" name="meta_description">
                    @endif
                    </div>
                </div>

                <div>
                    <label>Ключові слова (meta_keywords): </label>
                    <div>
                    @if(isset($data->meta_keywords))
                        <input placeholder="ключеве, область, якість" name="meta_keywords" value="{{$data->meta_keywords}}" >
                    @else
                        <input placeholder="ключеве, область, якість" name="meta_keywords" >
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
    @include('js_blade.js_create')

@endsection