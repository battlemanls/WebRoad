@extends('layouts.my_app')

<link rel="stylesheet" href="{{asset('css/show_article.css')}}">
<link rel="stylesheet" href="{{asset('css/catalog.css')}}">
@section('title', 'Державне підприємство "Місцеві дороги запорізької області"')
@section('description', 'Галерея')
@section('keywords', 'фото, галерея')

@section('content')
    <div class="wrap_content">
        <div class="wrap_block">
                <div class="block">
                    <span class="span_gallery">Галерея</span>
            @if(isset($data))
                @foreach($data as $d)
            @if(isset($d->images_pg_ars))
                            <div class="img_block">
                                <span class="span_gallery_nth">{{$d->title}}:</span>
                                <div class="galleria">
                                    @foreach($d->images_pg_ars as $f)
                                        <a href="{{asset("/storage/uploads/images/". date_create($f->created_at)->Format('Y_m') . "/". "gallery/". "small/".$f->images->path)}}">
                                            <img alt="{{$d->title}}" data-big="{{asset("/storage/uploads/images/". date_create($f->created_at)->Format('Y_m') . "/". "gallery/". "big/".$f->images->path)}}" data-title="{{$d->title}}" data-description="&nbsp;" ></a>
                                    @endforeach
                                </div>
                            </div>
                <br>
                        @endif
                {{$data->links()}}
        @endforeach
        @endif
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



    <!-- Скрипты страницы -->


@endsection