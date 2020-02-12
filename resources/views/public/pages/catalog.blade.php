@extends('layouts.my_app')
<!--
<link rel="stylesheet" href="{{asset('css/show_article.css')}}">

@section('content')
    <div class="wrap_content">
        <div class="wrap_block">
            <div class="block">
                <div class="type_block">
                <span>
                    @if(isset($data->title))
                        {{$data->title}}
                    @endif
                </span>
                </div>


                <div class="body_block">
                    @if(isset($data->body))
                        {!!$data->body!!}
                    @endif

                </div>

                @if(isset($data->images_pg_ars)&&count($data->images_pg_ars)>0)
                    <div class="img_block">
                        <span>Галерея</span>
                        <div>
                            @foreach($data->images_pg_ars as $f)
                                <div><img src="{{asset("storage/uploads/images/small/".$f->images->path)}}" title="{{$f->images->title}}"></div>
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
            {{$data->links()}}

        </div>


    </div>

    <!-- Скрипты страницы -->
    <!--include('js_blade.js_create')-->

@endsection


