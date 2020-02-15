@extends('layouts.admin')

<link rel="stylesheet" href="{{asset('css/admin_panel/create.css')}}">

@section('content')
    <div class="wrap_content">
        @if(isset($data->title))
            <h2>Редагування публікації</h2>
        @else
            <h2>Добавление публікації</h2>
        @endif

        <div class="wrap_block">
            <form id='my_form' name="my_form" action="{{route('admin_panel.articles.store')}}" enctype="multipart/form-data" method="post">
                @csrf
                <div>
                    <label>Назва:</label>
                    <div>

                    @if(isset($data->title))@if($errors->get('title')!=null)
                                <label class="alert-danger_mini">{{$errors->get('title')[0]}}</label>
                            @endif
                        <input required  maxlength="191" placeholder="Назва метеріалу" name = 'title' value="{{$data->title}}">
                        @else
                                <input required  maxlength="191"  placeholder="назва метеріалу" name = 'title'>
                        @endif
                    </div>
                </div>

                <div>
                    <label>Тип публікації: </label>
                    <div>
                        @if(isset($data->id_type))
                            <select id="id_type" name="id_type">
                                <option selected value="{{$data->id_type}}">Обрано: {{$data->type_articlesss->name}}</option>
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
                    <label>Обложка: (.jpg, .png .heic) </label>
                    <div>
                        @if(isset($data->img_avatar))
                            <div> <img id="img_avatar" src="{{asset("/storage/uploads/images/". date_create($data->created_at)->Format('Y_m')
                            . "/". "avatar/". "big/".$data->img_avatar)}}" title="{{$data->img_avatar}}"></div>

                            <input  accept=".jpg, .jpeg, .png, .heic" id="input_avatar" type="file" name="img_avatar" value="{{$data->img_avatar}}">
                        @else
                            <div> <img id="img_avatar" src="" hidden></div>
                            <input  accept=".jpg, .jpeg, .png, .heic" id="input_avatar" type="file" name="img_avatar">
                        @endif
                    </div>
                </div>

                <div>
                    <label>Витяг: </label>
                    <div>
                        @if(isset($data->excerpt))
                            <textarea  maxlength="1000" rows="12" name="excerpt" >{{$data->excerpt}}</textarea>
                        @else
                            <textarea  maxlength="1000" rows="12" name="excerpt" ></textarea>
                        @endif
                    </div>
                </div>

                <div>
                    <label>Контент сторінки:</label>
                    <div>
                        @if($errors->get('title')!=null)
                            <label class="alert-danger_mini">{{$errors->get('body')[0]}}</label>
                        @endif
                        @if(isset($data->body))
                            <textarea name="body" id="editor-body_2">{{$data->body}}</textarea>
                        @else
                            <textarea name="body" id="editor-body_2"></textarea>
                        @endif
                    </div>
                </div>

                <div>
                    <label>Дата публікації</label>
                    <div>
                        @if(isset($data->date_advice))
                            <input type="date" name="date_advice" value="{{$data->date_advice}}">
                        @else
                            <input type="date" name="date_advice">
                        @endif
                    </div>
                </div>

                <div>
                    <label>Дата приховування публікації: </label>
                    <div>
                        @if(isset($data->date_advice_end))
                            <input type="date" name="date_advice_end" value="{{$data->date_advice_end}}">
                        @else
                            <input type="date" name="date_advice_end">
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
                        <input maxlength="191" placeholder="дорога, область, якість" name="meta_keywords" >
                    @endif
                    </div>
                </div>

                <div>
                    <label>Youtube: </label>
                    <div>
                        @if(isset($data->youtube))
                            <iframe id="video_youtube" src="{{$data->youtube}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            <input placeholder="https://www.youtube.com/watch?v=primer" type="url" id="id_youtube" name="youtube" value="{{$data->youtube}}">
                        @else
                            <input placeholder="https://www.youtube.com/watch?v=primer" type="url" name="youtube">
                        @endif
                    </div>
                </div>

            <!-- Скрытые поля -->
                <div hidden>
                    <input name="file" id="in_files" hidden>
                </div>

                <div hidden>
                    <input name="image" id="in_images" hidden>
                </div>
                @if(isset($data))
                    <input name="edit" value="edit" hidden>
                    <input name="id" value="{{$data->id}}" hidden>
                    @endif
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
                                <div><button type="submit" method = 'delete' class = 'delete'>Вилучити</button></div>
                            </form>
                        </div>
                    @endforeach
                @endif
            </div>

            <div>
                <label>Файли: (.doc, .docx, .txt, .pdf, .rar, .zip, .xlsx, .xlsm .xls)</label>
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
                    <label>Вже наявні зображення: </label>
                    <div>
                        @foreach($data->images_pg_ars as $f)
                            <div>
                                <form method = 'post' action="{{ route('images/delete', $f->images->id ) }}" class="idelete">
                                    @csrf
                                    {{method_field('post')}}
                                    <input hidden name="id" value={{$f->images->id}}>
                                    <div> <img src="{{asset("/storage/uploads/images/". date_create($f->created_at)->Format('Y_m') . "/". "gallery/". "small/".$f->images->path)}}"
                                               title="{{$f->images->title}}"></div>
                                    <div> <button type="submit" method = 'delete' class='delete'>Вилучити</button></div>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>

                @if (session('error'))
                    <div class="alert-danger">
                        <ul>
                            <li>Помилка: </li>
                            <li>- {{ session('error') }}</li>
                        </ul>
                    </div>
                @endif

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
                <label>Відобразити на головній:</label>
                <div class="on_main">
                    <div>Так</div>
                    @if(isset($on_main)&&$on_main==true)
                        <input form="my_form" class="in_check" name="on_main" type="checkbox" checked>
                    @else
                        <input form="my_form" class="in_check" name="on_main" type="checkbox">
                    @endif
                </div>
            </div>



            <div>
                <label>Попередній перегляд:</label>
                <div class="status">
                    <div>Так <span>(перегляд перед публікацією)</span></div>
                    @if(isset($data->status)&&$data->status==0)
                        <input form="my_form" class="in_check" name="status" type="checkbox" checked>
                    @else
                        <input form="my_form" class="in_check" name="status" type="checkbox">
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