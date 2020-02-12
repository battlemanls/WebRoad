<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/menu_admin.js') }}" defer></script>
  <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <!--  <script src="//cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script> <!-- Редактор текста -->
    <script src="{{ asset('js/dist/ckeditor/ckeditor.js')}}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin_panel/admin_head.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Anton|Bebas+Neue|Inria+Serif|Oswald|Roboto+Condensed&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!--Material Design Iconic Font-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!--  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    <!--Material Design Iconic Font-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Image Uploader CSS -->
    <link rel="stylesheet" href="{{ asset('js/dist/image-uploader.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
</head>
<body>
<div id="app">
    <header>

        <!-- Мобильная вресия сайта -->
        <div class="wrap_head_mobile">
            <div class="wrap_head_ico">
                <div><a href="https://www.zoda.gov.ua/"><img src="{{asset('icon/zaporizhia_oblast.png')}}"></a></div>
            </div>
            <div>
                Державне підприємство "Місцеві дороги запорізької області"
            </div>
            <div>
                <div class="menu__icon">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <div class="menu__mobile_none">
                <!--       <nav class="wrap_head_menu_mobile">
                        {{menu('main_menu')}}
                        </nav> -->
                    <ul>
                        <li><a href="{{route('admin_panel.index')}}"><span>Головна</span></a></li>
                        @if(Auth::user()->link_roles->name == 'jurnalist' || Auth::user()->link_roles->name == 'admin')
                            <li><a><span>Cтатті</span></a>
                                <ul>
                                    <li><a href="{{route('admin_panel.articles.create')}}" ><span>Додати статтю</span></a></li>
                                    <li><a href="{{route('admin_panel.articles.catalog')}}"><span>Каталог статей</span></a></li>
                                    <li><a href="{{route('admin_panel.blocknews.index')}}"><span>Новини на головній</span></a></li>
                                </ul>
                            </li>
                            <li><a><span>Cтан дороги</span></a>
                                <ul>
                                    <li><a href="{{route('admin_panel.stan_dorig.create')}}" ><span>Додати</span></a></li>
                                    <li><a href="{{route('admin_panel.stan_dorig.catalog')}}"><span>Каталог</span></a></li>
                                </ul>
                            </li>

                            <li><a href="{{route('admin_panel.roads.catalog')}}" ><span>Дороги</span></a>
                             <!--   <ul>
                                <!--  <li><a href="{{route('admin_panel.roads.create')}}" ><span>Додати</span></a></li> -->
                             <!--      <li><a href="{{route('admin_panel.roads.catalog')}}"><span>Каталог</span></a></li>
                                </ul> -->
                            </li>

                            <li><a href="{{route('admin_panel.pages.catalog')}}"><span>Сторінки</span></a></li>
                        @endif
                        @if(Auth::user()->link_roles->name == 'mapper' || Auth::user()->link_roles->name == 'admin')
                            <li><a href={{route('admin_panel.maps.edit')}}><span>Карта</span></a></li>
                        @endif
                        <li><a href="{{url('/')}}"><span>Повернутися на сайт</span></a></li>
                        <li title="hello"><span>Добридень, {{ Auth::user()->name }}</span></li>
                        <li title="logout"><a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();"><span>
                            {{ __('Вийти') }}</span>
                            </a>
                           <!-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form> -->
                        </li>
                  </ul>
                </div>
            </div>
        </div>

        <div class="wrap_head_admin">
            <div class="wrap_head_admin_left">
                <div><a href="{{url('/')}}"><div><span>Повернутися на сайт</span></div></a></div>
                <div><span>Адмін панель</span></div>
            </div>
            <div class="wrap_head_admin_right">

                @if(isset(Auth::user()->name))
                <div><span>
                    Добридень, {{ Auth::user()->name }} <span class="caret"></span>
                </span></div>
                @endif

                <div><a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();"><span>
                            {{ __('Вийти') }}</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
        </div>
    </header>

    <nav class="wrap_head_menu">
        <ul>
            <li><a href="{{route('admin_panel.index')}}"><span>Головна</span></a></li>
            @if(Auth::user()->link_roles->name == 'jurnalist' || Auth::user()->link_roles->name == 'admin')
            <li><a><span>Статті</span></a>
                <ul>
                    <li><a href="{{route('admin_panel.articles.create')}}" ><span>Додати статтю</span></a></li>
                    <li><a href="{{route('admin_panel.articles.catalog')}}"><span>Каталог статей</span></a></li>
                    <li><a href="{{route('admin_panel.blocknews.index')}}"><span>Новини на головній</span></a></li>
                </ul>
            </li>

                <li><a><span>Стан доріг</span></a>
                    <ul>
                        <li><a href="{{route('admin_panel.stan_dorig.create')}}" ><span>Додати</span></a></li>
                        <li><a href="{{route('admin_panel.stan_dorig.catalog')}}"><span>Каталог</span></a></li>
                    </ul>
                </li>

                <li><a href="{{route('admin_panel.roads.catalog')}}"><span>Дороги</span></a>
                </li>

            <li><a href="{{route('admin_panel.pages.catalog')}}"><span>Сторінки</span></a></li>
            @endif
            @if(Auth::user()->link_roles->name == 'mapper' || Auth::user()->link_roles->name == 'admin')
            <li><a href={{route('admin_panel.maps.edit')}}><span>Карта</span></a></li>
            @endif
        </ul>
    </nav>
    <main>

        <!--Ошибки валидации -->
        @if (count($errors) > 0)
            <div class="alert-danger">
                <ul>
                    <li>Помилки: </li>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <!--Ошибки исключительных ситуаций -->
            @if (session('error'))
                <div class="alert-danger">
                <ul>
                    <li>Помилка: </li>
                    <li>- {{ session('error') }}</li>
                </ul>
                </div>
            @endif

    <!--Сообшение об успешнов выполнении -->
        @if (session('success'))
            <div class="alert_success">
                <ul>
                    <li>{{session('success')}}</li>
                </ul>
            </div>
        @endif
        @yield('content')
    </main>
    <footer>
    </footer>
</div>

<!-- Image Uploader Js -->
<script type="text/javascript" src="{{ asset('js/dist/image-uploader.min.js')}}"></script>

</body>

</html>