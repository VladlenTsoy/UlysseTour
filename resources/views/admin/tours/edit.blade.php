@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Туры</div>
                    <div class="card-body">
                        <form  class="was-validated" action="/admin/tour/{{$id}}/edit/{{$lang}}" enctype="multipart/form-data" method="post">
                            {!! csrf_field() !!}

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meta_title">Название (Метатег)</label>
                                        <input type="text" class="form-control" id="meta_title" name="meta_title"
                                               placeholder="Введите название" value="{{$tour->meta_title}}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="url">Ссылка (Url)</label>
                                        <input type="text" class="form-control" id="url" name="url"
                                               placeholder="Введите название" value="{{$tour->url}}" required>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meta_desc">Описание (Метатег)</label>
                                        <textarea class="form-control" id="meta_desc" name="meta_description" required
                                                  rows="5">{{$tour->meta_description}}</textarea>
                                    </div>

                                </div>

                                <div class="col-12">
                                    <hr>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Название</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                               placeholder="Введите название" required value="{{$tour->title}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="category">Категория</label>
                                        <select class="form-control" id="category" name="category">
                                            @foreach($categories as $val)
                                                <option value="{{$val->id}}"
                                                        @if($tour->category == $val->id) selected @endif>{{$val->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="duration">Продолжительность</label>
                                        <input type="text" class="form-control" id="duration" name="duration"
                                               placeholder="Введите продолжительность" required value="{{$tour->duration}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="cost">Цена</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="cost" name="cost"
                                                   placeholder="Введите сумму" required value="{{$tour->cost}}">
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
                                                <option value="{{$val->id}}"
                                                        @if(isset($tour->city))
                                                        @foreach($tour->city as $city)
                                                        @if($city == $val->id) selected @endif
                                                        @endforeach
                                                        @endif
                                                >{{$val->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="max_qty_tourists">Максимально число туристов</label>
                                        <input type="text" class="form-control" id="max_qty_tourists"
                                               name="max_qty_tourists" placeholder="Введите максимально число туристов"
                                               required value="{{$tour->max_qty_tourists}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="season">Сезон</label>
                                        <select class="form-control" id="season" name="season">
                                            @foreach($seasons as $val)
                                                <option value="{{$val->id}}"
                                                        @if($tour->season == $val->id) selected @endif>{{$val->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="schedule">Расписание рейсов</label>
                                        <select name="schedule" class="form-control" id="schedule">
                                            <optgroup label="">
                                                <option @if($tour->schedule === 'c10335') selected @endif  value="c10335">Ташкент</option>
                                                <option @if($tour->schedule === 'c10336') selected @endif  value="c10336">Фергана</option>
                                                <option @if($tour->schedule === 'c10330') selected @endif  value="c10330">Бухара</option>
                                                <option @if($tour->schedule === 'c10331') selected @endif  value="c10331">Карши</option>
                                                <option @if($tour->schedule === 'c21314') selected @endif  value="c21314">Наманган</option>
                                                <option @if($tour->schedule === 'c10296') selected @endif  value="c10296">Навои</option>
                                                <option @if($tour->schedule === 'c10337') selected @endif  value="c10337">Нукус</option>
                                                <option @if($tour->schedule === 'c10334') selected @endif  value="c10334">Самарканд</option>
                                                <option @if($tour->schedule === 'c10338') selected @endif  value="c10338">Термез</option>
                                                <option @if($tour->schedule === 'c21105') selected @endif  value="c21105">Ургенч</option>
                                            </optgroup>
                                            <optgroup label="">
                                                <option @if($tour->schedule === 'c11508') selected @endif  value="c11508">Стамбул</option>
                                                <option @if($tour->schedule === 'c10562') selected @endif  value="c10562">Дели</option>
                                                <option @if($tour->schedule === 'c10604') selected @endif  value="c10604">Куала Лумпур</option>
                                                <option @if($tour->schedule === 'c213') selected @endif  value="c213">Москва</option>
                                                <option @if($tour->schedule === 'c10445') selected @endif  value="c10445">Рим</option>
                                                <option @if($tour->schedule === 'c131') selected @endif  value="c131">Тель Авив</option>
                                                <option @if($tour->schedule === 'c26816') selected @endif  value="c26816">Амритсар</option>
                                                <option @if($tour->schedule === 'c10620') selected @endif  value="c10620">Бангкок</option>
                                                <option @if($tour->schedule === 'c10590') selected @endif  value="c10590">Пекин</option>
                                                <option @if($tour->schedule === 'c11499') selected @endif  value="c11499">Дубай</option>
                                                <option @if($tour->schedule === 'c10616') selected @endif  value="c10616">Лахор</option>
                                                <option @if($tour->schedule === 'c202') selected @endif  value="c202">Нью Йорк</option>
                                                <option @if($tour->schedule === 'c10635') selected @endif  value="c10635">Сеул</option>
                                                <option @if($tour->schedule === 'c10594') selected @endif  value="c10594">Урумчи</option>
                                                <option @if($tour->schedule === 'c100') selected @endif  value="c100">Франкфурт</option>
                                                <option @if($tour->schedule === 'c10393') selected @endif  value="c10393">Лондон</option>
                                                <option @if($tour->schedule === 'c10502') selected @endif  value="c10502">Париж</option>
                                                <option @if($tour->schedule === 'c20843') selected @endif  value="c20843">Шарджа</option>
                                                <option @if($tour->schedule === 'c10448') selected @endif  value="c10448">Милан</option>
                                                <option @if($tour->schedule === 'c10619') selected @endif  value="c10619">Сингапур</option>
                                            </optgroup>
                                            <optgroup label="">
                                                <option @if($tour->schedule === 'c22177') selected @endif  value="c22177">Алматы</option>
                                                <option @if($tour->schedule === 'c10318') selected @endif  value="c10318">Душанбе</option>
                                                <option @if($tour->schedule === 'c62') selected @endif  value="c62">Красноярск</option>
                                                <option @if($tour->schedule === 'c39') selected @endif  value="c39">Ростов</option>
                                                <option @if($tour->schedule === 'c55') selected @endif  value="c55">Тюмень</option>
                                                <option @if($tour->schedule === 'c163') selected @endif  value="c163">Астана</option>
                                                <option @if($tour->schedule === 'c54') selected @endif  value="c54">Екатеринбург</option>
                                                <option @if($tour->schedule === 'c35') selected @endif  value="c35">Краснодар</option>
                                                <option @if($tour->schedule === 'c2') selected @endif  value="c2">Санкт-Петербург</option>
                                                <option @if($tour->schedule === 'c172') selected @endif  value="c172">Уфа</option>
                                                <option @if($tour->schedule === 'c10253') selected @endif  value="c10253">Баку</option>
                                                <option @if($tour->schedule === 'c22') selected @endif  value="c22">Калининград</option>
                                                <option @if($tour->schedule === 'c11063') selected @endif  value="c11063">Минеральные Воды</option>
                                                <option @if($tour->schedule === 'c51') selected @endif  value="c51">Самара</option>
                                                <option @if($tour->schedule === 'c193') selected @endif  value="c193">Воронеж</option>
                                                <option @if($tour->schedule === 'c10309') selected @endif  value="c10309">Бишкек</option>
                                                <option @if($tour->schedule === 'c43') selected @endif  value="c43">Казань</option>
                                                <option @if($tour->schedule === 'c157') selected @endif  value="c157">Минск</option>
                                                <option @if($tour->schedule === 'c65') selected @endif  value="c65">Новосибирск</option>
                                                <option @if($tour->schedule === 'c239') selected @endif  value="c239">Сочи</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Описание</label>
                                <textarea class="form-control" id="news-description"
                                          name="description">{{$tour->description}}</textarea>
                            </div>


                            <div class="form-group">

                                <p><b>Программа</b></p>

                                <div class="program-block">
                                    @foreach($tour->program as $key => $program)
                                        <div class="block-current-program">
                                            <label for="day_title_{{$key + 1}}">День {{$key + 1}}
                                                <span class="deleteButton"> Удалить</span>
                                            </label>
                                            <div class="form-group">
                                                <input type="text" name="program_title[]" class="form-control"
                                                       placeholder="Введите заголовок дня программы"
                                                       value="{{$program->title}}">
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" name="program_desc[]"
                                                          id="day_{{$key + 1}}">{{$program->description}}</textarea>
                                            </div>
                                        </div>
                                    @endforeach
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
                                                <option value="{{$val->id}}"
                                                        @if(isset($tour->include_transport))
                                                        @foreach($tour->include_transport as $item)
                                                        @if($item == $val->id) selected @endif
                                                        @endforeach
                                                        @endif
                                                >{{$val->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="guideSevices">Гид</label>
                                        <select class="form-control js-example-basic-multiple" multiple="multiple"
                                                id="guideSevices" name="include_guide[]">
                                            @foreach($guideSevices as $val)
                                                <option value="{{$val->id}}"
                                                        @if(isset($tour->include_guide))
                                                        @foreach($tour->include_guide as $item)
                                                        @if($item == $val->id) selected @endif
                                                        @endforeach
                                                        @endif
                                                >{{$val->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="accommodations">Проживание</label>
                                        <select class="form-control js-example-basic-multiple" multiple="multiple"
                                                id="accommodations" name="include_accommodations[]">
                                            @foreach($accommodations as $val)
                                                <option value="{{$val->id}}"
                                                        @if(isset($tour->include_accommodations))
                                                        @foreach($tour->include_accommodations as $item)
                                                        @if($item == $val->id) selected @endif
                                                        @endforeach
                                                        @endif
                                                >{{$val->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="food">Питание</label>
                                        <select class="form-control js-example-basic-multiple" multiple="multiple"
                                                id="food" name="include_food[]">
                                            @foreach($food as $val)
                                                <option value="{{$val->id}}"
                                                        @if(isset($tour->include_food))
                                                        @foreach($tour->include_food as $item)
                                                        @if($item == $val->id) selected @endif
                                                        @endforeach
                                                        @endif
                                                >{{$val->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="services">Услуги</label>
                                        <select class="form-control js-example-basic-multiple" multiple="multiple"
                                                id="services" name="include_services[]">
                                            @foreach($services as $val)
                                                <option value="{{$val->id}}"
                                                        @if(isset($tour->include_service))
                                                        @foreach($tour->include_service as $item)
                                                        @if($item == $val->id) selected @endif
                                                        @endforeach
                                                        @endif
                                                >{{$val->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="ad_services">Доп. Услуги</label>
                                        <select class="form-control js-ad-multiple" multiple="multiple" id="ad_services"
                                                name="ad_services[]">
                                            @foreach($services as $val)
                                                <option value="{{$val->id}}"
                                                        @if(isset($tour->ad_service))
                                                        @foreach($tour->ad_service as $item)
                                                        @if($item == $val->id) selected @endif
                                                        @endforeach
                                                        @endif
                                                >{{$val->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    @if($tour->image)
                                        <div class="form-group">
                                            <label for="image-select" class="image-selection success">
                                                <span class="title-image-selection"
                                                      id="title-image">Выберите картинку</span>
                                                <input type="file" hidden="hidden" id="image-select" name="image">
                                                <img src="{{$tour->image}}" class="out-image" id="out-image">
                                            </label>
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <label for="image-select" class="image-selection">
                                                <span class="title-image-selection"
                                                      id="title-image">Выберите картинку</span>
                                                <input type="file" hidden="hidden" id="image-select" name="image"
                                                       required>
                                                <img src="" class="hideme out-image" id="out-image">
                                            </label>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary btn-clear" type="button">Удалить маркеры</button>
                                    <div class="block-map" id="map"></div>

                                    <div class="hideme inputLocation">
                                        @foreach($tour->route as $value)
                                            <input type="text" name="lat[]" value="{{$value->lat}}">
                                            <input type="text" name="lng[]" value="{{$value->lng}}">
                                        @endforeach
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="conditions">Условия</label>
                                        <textarea name="conditions" class="form-control"
                                                  id="conditions">{{$tour->conditions}}</textarea>
                                    </div>

                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="join_group" value="1" @if($tour->join_group) checked @endif>
                                        <label class="custom-control-label" for="customCheck1">
                                            <span class="" style="padding-left: 1.5rem">Груповой тур</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Регион</label>
                                        <select class="form-control" id="country" name="country">
                                            <option value="0" @if($tour->country == 0) selected @endif>Центральная
                                                азия
                                            </option>
                                            <option value="1" @if($tour->country == 1) selected @endif>Узбекистан
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <input class="form-control" disabled="disabled" value="Язык {{$lang}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="hot">Дата (Горящий)</label>
                                        <input type="date" class="form-control" id="hot" name="hot" value="{{$tour->hot}}">
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

