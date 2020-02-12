@extends('layouts.my_app')

<link rel="stylesheet" href="{{asset('css/show_article.css')}}">
<script src="{{ asset('js/js_smart_view_images.js') }}" defer></script>

@section('content')
    <div class="wrap_content">
        <div class="wrap_block">
            <div class="block">
                <div class="type_block">
                <h1>
                    @if(isset($data->title))
                        {!! strip_tags($data->title)!!}
                    @endif
                </h1>
                </div>

                <div class="body_block">
                    @if(isset($data->body))
                        {!!$data->body!!}
                    @endif
                </div>

                @if(isset($data->images_pg_ars)&&count($data->images_pg_ars)>0)
                    <div class="img_block">
                        <span>Галерея</span>
                        <div class="galleria">
                            @foreach($data->images_pg_ars as $f)
                                <a href="{{asset("/storage/uploads/images/". date_create($f->created_at)->Format('Y_m') . "/". "gallery/". "small/".$f->images->path)}}">
                                    <img data-big="{{asset("/storage/uploads/images/". date_create($f->created_at)->Format('Y_m') . "/". "gallery/". "big/".$f->images->path)}}" data-title="{{$data->title}}" data-description="{{$data->description}}" ></a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(isset($data->youtube))
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
        </div>
        @include('public._read_more')
    </div>

    <!-- Скрипты страницы -->

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