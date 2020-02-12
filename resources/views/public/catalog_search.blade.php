@extends('layouts.my_app')

<link rel="stylesheet" href="{{asset('css/show_article.css')}}">
<link rel="stylesheet" href="{{asset('css/catalog.css')}}">
@section('title', 'Державне підприємство "Місцеві дороги запорізької області"')
@section('description', 'Новини')
@section('keywords', 'новини, місцеві, дороги, запорізька, область')

@section('content')
    <div class="wrap_content">
        <div class="wrap_block">
            <div class="block">
                <div class="type_block">
                <span>
                    @if(isset($search))
                        Результат пошуку за запитом: {{$search}}
                    @endif
                </span>
                </div>
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
                                <div><span>{{$c->title}}</span>
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