@extends('layouts.my_app')

<link rel="stylesheet" href="{{asset('css/show_article.css')}}">
<script src="{{ asset('js/js_smart_view_images.js') }}" defer></script>

@if(isset($data->title))
    @section('title', $data->title)
@endif
@section('description', $data->meta_description)
@section('keywords', $data->meta_keywords)

@section('content')


    <div class="wrap_content">

        <div id="url_img" hidden>{{asset("/storage/uploads/images/". date_create($data->created_at)->Format('Y_m') . "/". "avatar/". "big/".$data->img_avatar)}}</div>

        <div id="myModal" class="modal">
            <!-- The Close Button -->
            <span class="close">&times;</span>
            <!-- Modal Content (The Image) -->
            <img alt="{{$data->title}}" class="modal-content" id="img01">
            <!-- Modal Caption (Image Text) -->
            <div id="caption">{{$data->title}}</div>
        </div>

        <div class="wrap_block">
            <div class="block">
                <div class="type_block">
                <span>
                    @if(isset($data->type_articlesss->name))
                        {{$data->type_articlesss->name}}
                    @endif
                </span>
                </div>

                @if(isset($data->img_avatar))

                    <div id="myImg" class="title_block"  style="background: url('{{asset("/storage/uploads/images/". date_create($data->created_at)->Format('Y_m') .
                 "/". "avatar/". "big/".$data->img_avatar)}}') no-repeat; background-size: cover;
                            background-position: center;">

                        <div>
                        <span>
                        @if(isset($data->title))
                                {{$data->title}}
                            @endif
                    </span>
                        </div>

                        @if(isset($data->created_at))
                            <div>
                        <span>

                                {{$data->created_at}}

                        </span>
                            </div>
                        @endif

                    </div>
                @else
                    <div class="title_block_small">

                        <div>
                        <span>
                        @if(isset($data->title))
                                {{$data->title}}
                            @endif
                        </span>
                        </div>

                        @if(isset($data->created_at))
                            <div>
                        <span>
                                {{$data->created_at}}
                        </span>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="body_block">
                <span>
                    @if(isset($data->body))
                        {!! $data->body!!}
                    @endif
                </span>
                </div>

                @if(isset($data->images_pg_ars)&&count($data->images_pg_ars)>0)
                    <div class="img_block">
                        <span>Галерея</span>
                        <div class="galleria">
                            @foreach($data->images_pg_ars as $f)
                                <a href="{{asset("/storage/uploads/images/". date_create($f->created_at)->Format('Y_m') . "/". "gallery/". "small/".$f->images->path)}}">
                                    <img alt="{{$data->title}}" data-big="{{asset("/storage/uploads/images/". date_create($f->created_at)->Format('Y_m') . "/". "gallery/". "big/".$f->images->path)}}" data-title="{{$data->title}}" data-description="{{$data->description}}" ></a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(isset($data->youtube)&&$data->youtube!='')
                    <div class="youtube_block">
                        <span>Видео</span>
                        <iframe id="video_youtube" src="{{$data->youtube}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                @endif

                @if(isset($data->files_pg_ars)&&count($data->files_pg_ars)>0)
                    <div class="file_block">
                        <span>Документы</span>
                        @foreach($data->files_pg_ars as $f)
                            <a href="{{asset("storage/uploads/files/". date_create($f->created_at)->Format('Y_m') . '/' . $f->files->path)}}">
                                <span>{{$f->files->title}}</span></a>
                        @endforeach
                    </div>
                @endif
            </div>



            <div class="pre_block">
                <form method = 'post' action="{{ route('admin_panel.articles.confirm' ) }}" >
                    @csrf
                    <input hidden name = 'id' value={{$data->id}}>
                    <button id="save" type="submit"><span>Сохранить</span></button>
                </form>

                <a href="{{route('admin_panel.articles.edit',[$data->id])}}"><button id="edit"><span>Редактировать</span></button></a>
                <form method = 'post' action="{{ route('admin_panel.articles.delete', $data->id ) }}" >
                    @csrf
                    {{method_field('DELETE')}}
                    <div><button id="delete" type="submit" ><span>Вилучити</span></button></div>
                </form>
            </div>


            </div>

    </div>


    <script>
        $(function() {
            var photos = $('.img_block');
            if(photos.length!=0) {
                Galleria.loadTheme("{{asset('js/dist/galleria/dist/themes/azur/galleria.azur.min.js')}}");
                Galleria.run('.galleria');
                Galleria.configure({
                    imageCrop: false,
                    fullscreenTransition: true,
                    transition: 'slide',
                    _toggleCaption: false,
                    _showTooltip: false,
                    _showCaption: false,
                    _locale: {
                        show_captions: 'Інформація',
                        hide_captions: 'Скрити',
                        play: 'Слайд шоу',
                        pause: 'Пауза',
                        enter_fullscreen: 'Повноекранний режим',
                        exit_fullscreen: 'Вихід з повноекранного режиму',
                        next: 'Наступне зображення',
                        prev: 'Попереднє зображення',
                        showing_image: 'Картинка за номерем %s із %s'
                    }
                });
            }
        });

    </script>


@endsection