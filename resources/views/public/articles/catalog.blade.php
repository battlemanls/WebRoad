@extends('layouts.my_app')

<link rel="stylesheet" href="{{asset('css/show_article.css')}}">
<link rel="stylesheet" href="{{asset('css/catalog.css')}}">
@section('title', 'Новини Державного підприємства "Місцеві дороги запорізької області"')
@section('description', 'Сторінка з новинами')
@section('keywords', 'новини, місцеві, дороги, запорізька, область')

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

                @if(isset($data->body))
                <div class="body_block">
                        {!!$data->body!!}
                </div>
                @endif

                @if(isset($data->images_pg_ars)&&count($data->images_pg_ars)>0)
                    <div class="img_block">
                        <span>Галерея</span>
                        <div>
                            @foreach($data->images_pg_ars as $f)
                                <div><img src="{{asset("/storage/uploads/images/". date_create($f->created_at)->Format('Y_m') .
                 "/". "avatar/". "big/".$f->img_avatar)}}" title="{{$f->images->title}}"></div>
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
                            <a href="{{asset("storage/uploads/files/".$f->files->path)}}"><span>{{$f->files->title}}</span></a>
                        @endforeach
                    </div>
                @endif
            </div>

            @if(isset($catalog))
                @foreach($catalog as $c)
                    <div class="block_nth">
                        <div>
                            <div>
                                @if(isset($c->img_avatar))
                                <img class="img" src="{{asset("/storage/uploads/images/". date_create($c->created_at)->Format('Y_m') .
                 "/". "avatar/". "big/".$c->img_avatar)}}">
                                @else
                                <img class="img" src="{{asset("icon/default/latest-news.jpg")}}">
                                @endif
                                <!--<img src="{{asset("storage/uploads/images/articles_avatar/small/".$c->img_avatar)}}"> -->
                            </div>
                            <div>
                                <div><h3>{!! strip_tags($c->title)!!}</h3>
                                </div>
                                <div>
                                    <span>{{$c->created_at}}</span>
                                </div>
                                <div>
                                    <span>{!!  strip_tags($c->excerpt) !!}</span>
                                </div>
                            </div>
                        </div>
                        <div><a  href="{{route('articles.show', $c->id )}}"><button class="save"><span>Докладніше</span></button></a></div>
                    </div>
                @endforeach
                    {{$catalog->links()}}
                @endif
        </div>
    </div>
    <!-- Скрипты страницы -->
@endsection