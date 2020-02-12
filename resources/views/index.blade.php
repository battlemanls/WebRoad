@extends('layouts.my_app')

@section('title', 'Державне підприємство "Місцеві дороги запорізької області"')
@section('description', 'Головона сторінка сайту')
@section('keywords', 'місцеві, дороги, запорізька, область')

@section('content')
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <div class="container">
        <div class="wrap_head_logo">
            <h1>Державне підприємство<br> «Місцеві дороги Запорізької області»</h1>
        </div>

        <div class="wrap_main_map">
            <div id="map">
                <iframe src="{{$maps->url}}" width="100%" height="600" frameborder="0" marginwidth="0"></iframe>
            </div>
        </div>

        <div class="wrap_main_info">
            <div class="wrap_main_info_news">
                <div class="wrap_main_info_news_top">
                    <h2>Новини</h2>
                    <div class="wrap_main_info_news_news">
                        @if(isset($news))
                            @foreach($news as $n)
                                <a  href="{{route('articles.show', $n->id_articles)}}">
                                    <div>
                                        <div>
                                            <span>
                                            {{$n->title}}
                                            </span>
                                        </div>
                                        <div>
                                            @if(isset($n->excerpt))
                                                {!! strip_tags($n->excerpt) !!}
                                            @else
                                                {!! strip_tags($n->body) !!}
                                            @endif
                                        </div>
                                    </div>
                                    @if(isset($n->img_avatar))
                                        <div class="img_news">
                                        <img src="{{asset("/storage/uploads/images/". date_create($n->created_at)->Format('Y_m') .
                 "/". "avatar/". "small/".$n->img_avatar)}}">
                                        </div>
                                    @else
                                        <div class="img_news">
                                            <img src="{{asset("icon/default/latest-news.jpg")}}">
                                        </div>
                                    @endif
                                </a>
                            @endforeach
                        @endif
                    </div>

                    <div class="wrap_main_info_news_news_2">
                        @if(isset($news))
                            @foreach($news as $n)
                                <a  href="{{route('articles.show', $n->id_articles)}}">
                                    @if(isset($n->img_avatar))
                                        <img  class="img_news" src="{{asset("/storage/uploads/images/". date_create($n->created_at)->Format('Y_m') .
                 "/". "avatar/". "small/".$n->img_avatar)}}"  title="{{$n->title}}">
                                    @else
                                        <img class="img_news" src="{{asset("icon/default/latest-news.jpg")}}" title="{{$n->title}}">
                                    @endif
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="wrap_main_info_news_anons">
                    @if(isset($anons))
                        <h2>Анонси</h2>
                        <a  href="{{route('articles.show', $anons->id)}}"><div><span>{!! strip_tags($anons->excerpt) !!}</span></div></a>
                    @endif
                </div>
            </div>
        </div>

        <div class="wrap_main_sub">
            <h2>Cтан доріг держзначення</h2>
            <div><a  href="{{url($roads->url)}}">
                    <div class="img_news"> @if(isset($roads->img_avatar))
                            <img src="{{asset("/storage/uploads/images/". date_create($roads->created_at)->Format('Y_m') .
                 "/". "avatar/". "small/".$roads->img_avatar)}}">
                        @else
                            <img src="{{asset("icon/default/latest-news.jpg")}}">
                        @endif</div>
                    <div>{{$roads->title}}</div> </a>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.wrap_main_info_news_news_2').bxSlider({
                captions: true,
                 //  slideWidth: 300,
                minSlides: 1,
                maxSlides: 5,
                slideMargin: 10,
                touchEnabled: false,
                /* ticker:true,
                 tickerHover:true,*/
                auto: true,
               stopAutoOnClick: true,
                pause: 7000,
                speed: 200,
            });
        })
    </script>

    <script>
        $(function () {
        $('#map')
            .click(function(){
                $(this).find('iframe').addClass('clicked')})
            .mouseleave(function(){
                $(this).find('iframe').removeClass('clicked')});
        })
    </script>

@endsection