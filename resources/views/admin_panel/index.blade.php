@extends('layouts.admin')
<link rel="stylesheet" href="{{asset('css/admin_panel/index.css')}}">

@section('content')
    <div class="wrap_content">
        <h2>Сторінка администратора</h2>
        <div class="wrap_pages">
            @if(Auth::user()->link_roles->name == 'jurnalist' || Auth::user()->link_roles->name == 'admin')
        <div class="block_nth">
            <a  href="{{route('admin_panel.articles.create')}}">
                <div><img src="{{asset('icon/article_add.png')}}"></div>
                <div><span>Додати статтю</span></div>
            </a>
        </div>

        <div class="block_nth">
            <a href="{{route('admin_panel.articles.catalog')}}">
                <div><img src="{{asset('icon/article.png')}}"></div>
                <div><span>Управління статтями</span></div>
            </a>
        </div>

            <div class="block_nth">
                <a href="{{route('admin_panel.blocknews.index')}}">
                    <div><img src="{{asset('icon/page_4.png')}}"></div>
                    <div><span>Статті на головній</span></div>
                </a>
            </div>

                <div class="block_nth">
                    <a href="{{route('admin_panel.stan_dorig.create')}}">
                        <div><img src="{{asset('icon/road_2.png')}}"></div>
                        <div><span>Додати стан дороги</span></div>
                    </a>
                </div>

                <div class="block_nth">
                    <a href="{{route('admin_panel.stan_dorig.catalog')}}">
                        <div><img src="{{asset('icon/road_3.png')}}"></div>
                        <div><span>Управління станом доріг</span></div>
                    </a>
                </div>

                <div class="block_nth">
                    <a href="{{route('admin_panel.roads.catalog')}}">
                        <div><img src="{{asset('icon/road_4.png')}}"></div>
                        <div><span>Управління дорогами</span></div>
                    </a>
                </div>

        <div class="block_nth">
            <a href="{{route('admin_panel.pages.catalog')}}">
                <div><img src="{{asset('icon/page.png')}}"></div>
                <div><span>Управління сторінками</span></div>
            </a>
        </div>
            @endif

            @if(Auth::user()->link_roles->name == 'mapper' || Auth::user()->link_roles->name == 'admin')
        <div class="block_nth">
            <a href={{route('admin_panel.maps.edit')}}>
                <div><img src="{{asset('icon/map.png')}}"></div>
                <div><span>Управління картою</span></div>
            </a>
        </div>
            @endif

            @if(Auth::user()->link_roles->name == 'admin')
        <div class="block_nth">
            <a href={{url('/admin_panel/pro/')}}>
                <div><img src="{{asset('icon/db.png')}}"></div>
                <div><span>Управління базою даних</span></div>
            </a>
        </div>
                @endif

                @if(Auth::user()->link_roles->name == 'admin')
                    <div class="block_nth">
                        <a href={{route('admin_panel.delete_trash')}}>
                            <div><img src="{{asset('icon/full-trash.png')}}"></div>
                            <div><span>Збір сміття</span></div>
                        </a>
                    </div>
                @endif
        </div>
    </div>

@endsection