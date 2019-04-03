<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@lang('header.brand')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 50px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">@lang('header.home')</a>
                        <a class="nav-link" href="/locale/en">EN</a>
                        <a class="nav-link" href="/locale/ru">RU</a>
                    @else
                        <a href="{{ route('login') }}">@lang('welcome.login')</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">@lang('register')</a>
                        @endif
                        <a class="nav-link" href="/locale/en">EN</a>
                        <a class="nav-link" href="/locale/ru">RU</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">@lang('welcome.message')</div>

                <div class="links">
                    <a href="https://github.com/dave-ninja" target="_blank">GitHub Dave</a>
                </div>
            </div>
        </div>
    </body>
</html>
