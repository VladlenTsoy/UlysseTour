<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
    <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ulysse') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/admin/home') }}">
                {{ config('app.name', 'Ulysse') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    @guest
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/admin/home')}}">{{ __('Главная') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/admin/tours')}}">{{ __('Туры') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/admin/news')}}">{{ __('Новости') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/admin/guides')}}">{{ __('Путеводитель') }}</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Дополнительные
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{url('/admin/categories')}}">Категории</a>
                                <a class="dropdown-item" href="{{url('/admin/cities')}}">Города</a>
                                <a class="dropdown-item" href="{{url('/admin/durations')}}">Продолжительность</a>
                                <a class="dropdown-item" href="{{url('/admin/food')}}">Питание</a>
                                <a class="dropdown-item" href="{{url('/admin/guide-sevice')}}">Услуги гида</a>
                                <a class="dropdown-item" href="{{url('/admin/season')}}">Сезоны</a>
                                <a class="dropdown-item" href="{{url('/admin/services')}}">Услуги</a>
                                <a class="dropdown-item" href="{{url('/admin/accommodations')}}">Проживание</a>
                                <a class="dropdown-item" href="{{url('/admin/include/transports')}}">Транспорт</a>
                            </div>
                        </li>
                    @endguest
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ \Illuminate\Support\Facades\Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Выход') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
<script src="{{ asset('js/admin.js') }}"></script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWGLQj3o0123ler7QE_TaJam7j5H306ng&callback=initMap"></script>

</html>
