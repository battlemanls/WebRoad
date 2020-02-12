@extends('layouts.admin')

<link rel="stylesheet" href="{{asset('css/admin_panel/create.css')}}">

@section('content')
    <div class="wrap_content">
        @if(isset($data->title))
            <h2>Редагування страницы</h2>
        @else
            <h2>Добавление страницы</h2>
        @endif

        <div class="wrap_block">

            <form id='my_form' name="my_form" action="{{route('admin_panel.pages.store')}}" enctype="multipart/form-data" method="post">
                @csrf
                <div>
                    <label>Назва:</label>
                    <div>
                        @if($errors->get('title')!=null)
                            <label class="alert-danger_mini">{{$errors->get('title')[0]}}</label>
                        @endif
                    @if(isset($data->title))
                        <input required  maxlength="191" placeholder="Назва сторінки" name = 'title' value="{{$data->title}}">
                        @else
                        <input required  maxlength="191" placeholder="Назва сторінки" name = 'title'>
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
                        <input maxlength="191" placeholder="дорога" name="meta_description" value="{{$data->meta_description}}">
                    @else
                        <input maxlength="191" placeholder="дорога" name="meta_description">
                    @endif
                    </div>
                </div>

                <div>
                    <label>Ключові слова (meta_keywords): </label>
                    <div>
                    @if(isset($data->meta_keywords))
                        <input maxlength="191" placeholder="ключеве, область, якість" name="meta_keywords" value="{{$data->meta_keywords}}" >
                    @else
                        <input maxlength="191" placeholder="ключеве, область, якість" name="meta_keywords" >
                    @endif
                    </div>
                </div>

                <!-- Скрытые поля -->
                @if(isset($data))
                    <input name="edit" value="edit" hidden>
                    <input name="id" value="{{$data->id}}" hidden>
                @endif

                <div hidden>
                    <input name="file" id="in_files" hidden>
                </div>

                <div hidden>
                    <input name="image" id="in_images" hidden>
                </div>

            </form>

            <div class="block_files">
                @if(isset($data->files_pg_ars))
                    <label>Вже наявні файли: </label>
                    @foreach($data->files_pg_ars as $f)
                        <div>
                            <form method = 'post' action="{{ route('files/delete', $f->files->id ) }}" class="fdelete">
                                @csrf
                                {{method_field('post')}}
                                <input hidden name="id" value={{$f->files->id}}>
                                <a href="{{asset("storage/uploads/files/". date_create($f->created_at)->Format('Y_m') . '/' . $f->files->path)}}">{{$f->files->title}}</a>
                                <div><button type="submit" method = 'delete' class="delete">Вилучити</button></div>
                            </form>
                        </div>
                    @endforeach
                @endif
            </div>

            <div>
                <label>Файли: (.doc, .docx, .txt, .pdf, .rar, .zip)</label>
                <div style="display: none" class="alert-danger"></div>
                <form class="dropzone" id="dropzone"
                      enctype="multipart/form-data"
                      action="{{url('files/store')}}"
                      method="post">
                    @csrf
                </form>
            </div>

            <div class="block_images">
                @if(isset($data->images_pg_ars))
                    <label>Вже наявні зображення:</label>
                    <div>
                        @foreach($data->images_pg_ars as $f)
                            <div>
                                <form method = 'post' action="{{ route('images/delete', $f->images->id ) }}" class="idelete">
                                    @csrf
                                    {{method_field('post')}}
                                    <input hidden name="id" value={{$f->images->id}}>
                                    <div> <img src="{{asset("/storage/uploads/images/". date_create($f->created_at)->Format('Y_m') . "/". "gallery/". "small/".$f->images->path)}}"
                                               title="{{$f->images->title}}"></div>
                                    <div> <button type="submit" method = 'delete' class="delete">Вилучити</button></div>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <label>Галерея: (.jpg, .png, .heic)</label>
                <div style="display: none" class="alert-danger"></div>
                <form class="dropzone" id="dropzone-img"
                      enctype="multipart/form-data"
                      action="{{url('images/store')}}"
                      method="post">
                    @csrf
                </form>
            </div>

            <div>
                <label>Допуск до перегляду:</label>
                <div class="status">
                    <div>Прихований <span>(перегляд можливий тількі через панель адміністратора)</span></div>
                    @if(isset($data->status)&&$data->status==0)
                        <input form="my_form" class="in_check" name="status" type="checkbox" checked value="{{$data->status}}">
                    @else
                        <input  form="my_form" class="in_check" name="status" type="checkbox">
                    @endif
                </div>
            </div>

            <div class="block_submit">
                <button form="my_form" class="button_submit" type="submit">ок</button>
            </div>

        </div>

    </div>

    <!-- Скрипты страницы -->
    @include('js_blade.js_create')

@endsection