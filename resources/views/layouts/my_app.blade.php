<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="Keywords" content="@yield('keywords')">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Anton|Bebas+Neue|Inria+Serif|Oswald|Roboto+Condensed&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!--Material Design Iconic Font-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('js/dist/bxslider/dist/jquery.bxslider.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Image Uploader CSS -->
    <link rel="stylesheet" href="{{ asset('js/dist/image-uploader.min.css')}}">
    <style>
        main{
            position: relative;
        }

        #page-preloader {
            overflow: hidden;
            position: absolute;
            left: 0;
            top: 0;
            right:0;
            bottom:0;
            background: white;
            z-index: 100500;
        }

        #page-preloader .spinner {
            width: 51px;
            height: 51px;
            position: fixed;
            left: 50%;
            top: 50%;
            background: url({{asset('/storage/gifs/load_5.gif')}}) no-repeat 50% 50%;
            /*   background: url('/images/spinner.gif') no-repeat 50% 50%;*/
            margin: -16px 0 0 -16px;
        }
    </style>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-88066162-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-88066162-2');
    </script>

</head>
<body>

<div id="app">
    <header>
       <!-- Мобильная вресия сайта -->
        <div class="wrap_head_mobile">
            <div class="wrap_head_ico">
                <div><a href="https://www.zoda.gov.ua/"><img src="{{asset('icon/zaporizhia_oblast.png')}}"></a></div>
            </div>
            <div><h1>Державне підприємство "Місцеві дороги Запорізької області"</h1>
            </div>
            <div>
                <div class="menu__icon">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="menu__mobile_none">
                 {{menu('main_menu')}}
                    <ul class="menu__mobile_none_search"><li>Пошук:</li>
                        <li>

                            <form method="get" class="wrap_head_search_form_moble" action="{{route('site.search')}}">
                                @csrf
                                @if(isset($search))
                                    <input value="{{$search}}" type="text" name="title_search">
                                @else
                                    <input type="text" name="title_search">
                                @endif
                                <a href="#" onclick="parentNode.submit();"><img src="{{asset('icon/search.png')}}"></a>
                            </form>
                        </li></ul>
                </div>
            </div>
        </div>

        <!-- Десктопная вресия сайта -->
        <div class="wrap_head">
          <div class="wrap_head_ico">
              <div><a href="https://www.zoda.gov.ua/"><img src="{{asset('icon/zaporizhia_oblast.png')}}"></a></div>
              <div><a href="https://www.facebook.com/DP.MDZO"><img src="{{asset('icon/facebook.png')}}"></a></div>
              <div><a href="https://www.youtube.com/channel/UCRa_7n3VA6D1A_GzF4JSNZw"><img src="{{asset('icon/youtube.png')}}"></a></div>
              <div><a href="https://ukravtodor.gov.ua/"><img src="{{asset('icon/ukravtodor.png')}}"></a></div>
              <div><a href="http://mtu.gov.ua/"><img src="{{asset('icon/min.png')}}"></a></div>
          </div>
          <div class="wrap_head_search">
              <form method="get" class="wrap_head_search_form" action="{{route('site.search')}}">
                  @if(isset($search))
                      <input value="{{$search}}" type="text" name="title_search">
                  @else
                  <input type="text" name="title_search">
                  @endif
                  <a onclick="parentNode.submit();"><img src="{{asset('icon/search.png')}}"></a>
              </form>
          </div>
      </div>

    </header>
<nav class="wrap_head_menu">
        {{menu('main_menu')}}
</nav>
   <!-- <div id="page-preloader"><span class="spinner"></span></div> -->
<main>
    <div id="page-preloader"><span class="spinner"></span></div>
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
        <div class="wrap_footer">
            <div class="wrap_footer_ico">
                <div><a href="https://www.zoda.gov.ua/"><img src="{{asset('icon/zaporizhia_oblast.png')}}"></a></div>
                <div><a href="https://www.facebook.com/DP.MDZO"><img src="{{asset('icon/facebook.png')}}"></a></div>
                <div><a href="https://www.youtube.com/channel/UCRa_7n3VA6D1A_GzF4JSNZw"><img src="{{asset('icon/youtube.png')}}"></a></div>
                <div><a href="https://ukravtodor.gov.ua/"><img src="{{asset('icon/ukravtodor.png')}}"></a></div>
                <div><a href="http://mtu.gov.ua/"><img src="{{asset('icon/min.png')}}"></a></div>
            </div>
            <div class="wrap_footer_contact">
                <div>вул. Поштова, 159Б м. Запоржжя,</div>
                <div>69095</div>
                <div>тел/факс:</div>
                <div>dpmdzo@ukr.net</div>
            </div>

            <div class="wrap_footer_license">
                <span>Використання матералів дозволяється за умови посилання на офiцiйний сайт</span>
            </div>
        </div>
    </footer>

</div>


<!-- Image Uploader Js -->
<script type="text/javascript" src="{{ asset('js/dist/image-uploader.min.js')}}"></script>
<script>
    //Анимация загрузки страницы
    $(window).on('load', function () {
        var $preloader = $('#page-preloader'),
            $spinner   = $preloader.find('.spinner');
        $spinner.fadeOut();
        $preloader.delay(250).fadeOut('slow');
        /* $('.preloader').fadeOut().end().delay(400).fadeOut('slow');*/
    });
</script>
<script src="{{ asset('js/menu.js') }}" defer></script>
<script src="{{ asset('js/dist/galleria/dist/galleria.js')}}"></script>
<script src="{{asset('js/dist/bxslider/dist/jquery.bxslider.min.js')}}" defer></script>

</body>
</html>