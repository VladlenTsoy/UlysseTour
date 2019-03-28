@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row ">

            <div class="col-12">
                <br>
                <p><b>Основные</b></p>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Туры</h5>
                        <a href="/admin/tours" class="btn btn-block btn-primary">Посмотреть</a>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Новости</h5>
                        <a href="/admin/news" class="btn btn-block btn-primary">Посмотреть</a>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Путеводитель</h5>
                        <a href="/admin/guides" class="btn btn-block btn-primary">Посмотреть</a>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <br>
                <p><b>Дополнительные</b></p>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Категории</h5>
                        <a href="/admin/categories" class="btn btn-block btn-success">Посмотреть</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Города</h5>
                        <a href="/admin/cities" class="btn btn-block btn-success">Посмотреть</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Продолжительность</h5>
                        <a href="/admin/durations" class="btn btn-block btn-success">Посмотреть</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Сезоны</h5>
                        <a href="/admin/season" class="btn btn-block btn-success">Посмотреть</a>
                    </div>
                </div>
            </div>

            <div class="col-12"><br></div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Услуги</h5>
                        <a href="/admin/include/services" class="btn btn-block btn-success">Посмотреть</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Питание</h5>
                        <a href="/admin/include/food" class="btn btn-block btn-success">Посмотреть</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Услуги гида</h5>
                        <a href="/admin/include/guide-sevice" class="btn btn-block btn-success">Посмотреть</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Транспорт</h5>
                        <a href="/admin/include/transports" class="btn btn-block btn-success">Посмотреть</a>
                    </div>
                </div>
            </div>

            <div class="col-12"><br></div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Проживание</h5>
                        <a href="/admin/include/accommodations" class="btn btn-block btn-success">Посмотреть</a>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <br>
                <p><b>Настройки</b></p>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Языки</h5>
                        <a href="/admin/languages" class="btn btn-block btn-warning">Посмотреть</a>
                    </div>
                </div>
            </div>

         <div class="col-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Баннеры</h5>
                        <a href="/admin/banners" class="btn btn-block btn-warning">Посмотреть</a>
                    </div>
                </div>
            </div>

            {{--<div class="col-4">--}}
                {{--<div class="card">--}}
                    {{--<div class="card-header">--}}
                        {{--Раздел--}}
                    {{--</div>--}}
                    {{--<div class="card-body text-center">--}}
                        {{--<h5 class="card-title">Отзывы</h5>--}}
                        {{--<a href="#" class="btn btn-block btn-warning">Посмотреть</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="col-4">--}}
                {{--<div class="card">--}}
                    {{--<div class="card-header">--}}
                        {{--Раздел--}}
                    {{--</div>--}}
                    {{--<div class="card-body text-center">--}}
                        {{--<h5 class="card-title">Доп. услуги</h5>--}}
                        {{--<a href="#" class="btn btn-block btn-warning">Посмотреть</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}


        </div>
    </div>
@endsection
