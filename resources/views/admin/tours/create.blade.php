@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Туры</div>
                    <div class="card-body">
                        <form action="/admin/tour/create/{{$lang}}" enctype="multipart/form-data" method="post">
                            {!! csrf_field() !!}

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Название</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                               placeholder="Введите название" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="category">Категория</label>
                                        <select class="form-control" id="category" name="category">
                                            @foreach($categories as $val)
                                                <option value="{{$val->id}}">{{$val->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="duration">Продолжительность</label>
                                        <input type="text" class="form-control" id="duration" name="duration"
                                               placeholder="Введите продолжительность" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="cost">Цена</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="cost" name="cost"
                                                   placeholder="Введите сумму" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">$</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">Город</label>
                                        <select class="form-control js-example-basic-multiple" multiple="multiple"
                                                id="city" name="city[]">
                                            @foreach($cities as $val)
                                                <option value="{{$val->id}}">{{$val->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="max_qty_tourists">Максимально число туристов</label>
                                        <input type="text" class="form-control" id="max_qty_tourists"
                                               name="max_qty_tourists" placeholder="Введите максимально число туристов"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label for="season">Сезон</label>
                                        <select class="form-control" id="season" name="season">
                                            @foreach($seasons as $val)
                                                <option value="{{$val->id}}">{{$val->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="schedule">Расписание рейсов</label>
                                        <select name="schedule" class="form-control" id="schedule">
                                            <optgroup label="">
                                                <option value="c10335" selected="">Ташкент</option>
                                                <option value="c10336">Фергана</option>
                                                <option value="c10330">Бухара</option>
                                                <option value="c10331">Карши</option>
                                                <option value="c21314">Наманган</option>
                                                <option value="c10296">Навои</option>
                                                <option value="c10337">Нукус</option>
                                                <option value="c10334">Самарканд</option>
                                                <option value="c10338">Термез</option>
                                                <option value="c21105">Ургенч</option>
                                            </optgroup>
                                            <optgroup label="">
                                                <option value="c11508">Стамбул</option>
                                                <option value="c10562">Дели</option>
                                                <option value="c10604">Куала Лумпур</option>
                                                <option value="c213">Москва</option>
                                                <option value="c10445">Рим</option>
                                                <option value="c131">Тель Авив</option>
                                                <option value="c26816">Амритсар</option>
                                                <option value="c10620">Бангкок</option>
                                                <option value="c10590">Пекин</option>
                                                <option value="c11499">Дубай</option>
                                                <option value="c10616">Лахор</option>
                                                <option value="c202">Нью Йорк</option>
                                                <option value="c10635">Сеул</option>
                                                <option value="c10594">Урумчи</option>
                                                <option value="c100">Франкфурт</option>
                                                <option value="c10393">Лондон</option>
                                                <option value="c10502">Париж</option>
                                                <option value="c20843">Шарджа</option>
                                                <option value="c10448">Милан</option>
                                                <option value="c10619">Сингапур</option>
                                            </optgroup>
                                            <optgroup label="">
                                                <option value="c22177">Алматы</option>
                                                <option value="c10318">Душанбе</option>
                                                <option value="c62">Красноярск</option>
                                                <option value="c39">Ростов</option>
                                                <option value="c55">Тюмень</option>
                                                <option value="c163">Астана</option>
                                                <option value="c54">Екатеринбург</option>
                                                <option value="c35">Краснодар</option>
                                                <option value="c2">Санкт-Петербург</option>
                                                <option value="c172">Уфа</option>
                                                <option value="c10253">Баку</option>
                                                <option value="c22">Калининград</option>
                                                <option value="c11063">Минеральные Воды</option>
                                                <option value="c51">Самара</option>
                                                <option value="c193">Воронеж</option>
                                                <option value="c10309">Бишкек</option>
                                                <option value="c43">Казань</option>
                                                <option value="c157">Минск</option>
                                                <option value="c65">Новосибирск</option>
                                                <option value="c239">Сочи</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Описание</label>
                                <textarea class="form-control" id="news-description" name="description"></textarea>
                            </div>


                            <div class="form-group">

                                <p><b>Программа</b></p>

                                <div class="program-block">

                                </div>

                                <button type="button" class="btn btn-primary btn-block" id="addProgram">
                                    Добавить
                                </button>

                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="transports">Транспорт</label>
                                        <select class="form-control js-example-basic-multiple" multiple="multiple"
                                                id="transports" name="include_transports[]">
                                            @foreach($transports as $val)
                                                <option value="{{$val->id}}">{{$val->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="guideSevices">Гид</label>
                                        <select class="form-control js-example-basic-multiple" multiple="multiple"
                                                id="guideSevices" name="include_guide[]">
                                            @foreach($guideSevices as $val)
                                                <option value="{{$val->id}}">{{$val->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="food">Питание</label>
                                        <select class="form-control js-example-basic-multiple" multiple="multiple"
                                                id="food" name="include_food[]">
                                            @foreach($food as $val)
                                                <option value="{{$val->id}}">{{$val->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="services">Услуги</label>
                                        <select class="form-control js-example-basic-multiple" multiple="multiple"
                                                id="services" name="include_services[]">
                                            @foreach($services as $val)
                                                <option value="{{$val->id}}">{{$val->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="accommodations">Проживание</label>
                                        <select class="form-control js-example-basic-multiple" multiple="multiple"
                                                id="accommodations " name="include_accommodations[]">
                                            @foreach($accommodations as $val)
                                                <option value="{{$val->id}}">{{$val->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="ad_services">Доп. Услуги</label>
                                        <select class="form-control js-ad-multiple" multiple="multiple" id="ad_services"
                                                name="ad_services[]">
                                            @foreach($services as $val)
                                                <option value="{{$val->id}}">{{$val->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="image-select" class="image-selection">
                                            <span class="title-image-selection"
                                                  id="title-image">Выберите картинку</span>
                                            <input type="file" hidden="hidden" id="image-select" name="image" required>
                                            <img src="" class="hideme out-image" id="out-image">
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary btn-clear" type="button">Удалить маркеры</button>
                                    <div class="block-map" id="map"></div>

                                    <div class="hideme inputLocation"></div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="conditions">Условия</label>
                                        <textarea name="conditions" class="form-control" id="conditions"></textarea>
                                    </div>

                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="join_group" value="1">
                                        <label class="custom-control-label" for="customCheck1">
                                            <span class="" style="padding-left: 1.5rem">Груповой тур</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Регион</label>
                                        <select class="form-control" id="country" name="country">
                                            <option value="0">Центральная азия</option>
                                            <option value="1">Узбекистан</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <input class="form-control" disabled="disabled" value="Язык {{$lang}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="hot">Дата (Горящий)</label>
                                        <input type="date" class="form-control" id="hot" name="hot">
                                    </div>
                                </div>

                                <div class="col-12 text-right">
                                    <button type="submit" class="btn btn-primary">
                                        Сохранить
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

