<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
    <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon">

    <title>{{$setting['title']}}</title>
    <meta name="description" content="{{$setting['description']}}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    @unless(isset($index))
        <link rel="stylesheet" href="{{asset('css/tours.css')}}">
        <link rel="stylesheet" href="{{asset('css/tour.css')}}">
    @endunless
</head>
<body>

<div class="wrap-top-slide" id="home"
     @unless(isset($index))
     style='
             background: url("@if(isset($setting["slide_img"])){{$setting["slide_img"]}}@else{{asset("./images/slide.png")}}@endif" ) center no-repeat;
             background-size: cover;'
     @else
     style="
             background: url( '{{isset($banners[0]) ? $banners[0]->image : asset('images/slide.png')}}' ) center no-repeat;
             background-size: cover;"
        @endunless
>
    <nav class="navbar navbar-expand-md fixed-top navbar-dark main-nav">
        <div class="container">
            <a class="nav-link nav-logo" href="/{{$_lang->title}}#home">
                <img src="{{asset('images/logo.svg')}}" alt="" width="150px">
            </a>
            <button class="navbar-toggler ml-2" type="button" data-toggle="collapse"
                    data-target=".nav-content"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="ml-auto navbar-collapse collapse nav-content">
                <ul class="nav navbar-nav mx-md-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/{{$_lang->title}}#home">{{$_lang->data->main}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="/{{$_lang->title}}/hot-tours/{{$_tags['hot-tours'][0]->user_url}}">{{$_lang->data->hot_tours}}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{$_lang->data->tours}}
                        </a>
                        <div class="dropdown-menu nav-dropdown" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                               href="/{{$_lang->title}}/tours/{{$_tags['tours-0'][0]->user_url}}?country=0">{{$_lang->data->country[0]}}</a>
                            <a class="dropdown-item"
                               href="/{{$_lang->title}}/tours/{{$_tags['tours-1'][0]->user_url}}?country=1">{{$_lang->data->country[1]}}</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/{{$_lang->title}}#about-us">{{$_lang->data->about_us}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/{{$_lang->title}}/news/{{$_tags['news'][0]->user_url}}">{{$_lang->data->news}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/{{$_lang->title}}/guide/{{$_tags['guides'][0]->user_url}}">{{$_lang->data->guide}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/{{$_lang->title}}#contacts">{{$_lang->data->contacts}}</a>
                    </li>
                </ul>
            </div>
            <div class="ml-auto navbar-collapse collapse nav-content">
                <ul class="ml-auto nav navbar-nav text-nowrap flex-row ">
                    @foreach($_languages as $val)
                        <li class="nav-item">
                            <a class="nav-link @if($val->title === $_lang->title) active @endif"
                               href="/{{$val->title}}">{{$val->title}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
    @if(isset($index))
        @yield('banner')
    @else
        <div class="col-12 wrap-text-on-slide">
            <div class="row text-on-slide align-items-center">
                <div class="col-12 text-center">
                    <span class="sub-text">{{$setting['slide_desc']}}</span>
                    <span class="main-text">{{$setting['slide_title']}}</span>
                    @if( isset($setting['request_tour']) && $setting['request_tour'])
                        <button class="btn btn-primary" type="button" style="margin-top: 0.5rem"
                                data-toggle="modal" data-target="#modalRequestTour"
                        >{{$_lang->data->request_tour}}</button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

@yield('content')

@if( !isset($setting['guide_off']) )
    <div class="block-content container">
        <div class=" title-block text-center">
            <span class="title-single">{{$_lang->data->guide}}</span>
        </div>

        <div class="block-news owl-carousel owl-theme">

            @foreach($_guides as $guide)
                <div class="block-news-once">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 text-center">
                            <span class="hot-offers-title">
                            {{$guide->title}}
                            </span>
                            </div>
                            <div class="col-12">
                                <p class="desc-content">
                                    {{$guide->min_description}}
                                </p>
                            </div>
                            <div class="col-12">
                                <a href="/{{$_lang->title}}/guide/{{$guide->id}}/{{$guide->url}}" class="btn btn-primary">
                                    {{$_lang->data->read_more}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>
@endif
<div class="block-content block-contacts" id="contacts">
    <div class="container">
        <div class="row">
            <div class="col-md-6 order-md-1 order-2 wrap-map">
                <div class="block-map" id="map">

                </div>
            </div>
            <div class="col-md-6 order-md-2 order-1">
                <div class="row">

                    <div class="col-3 text-right">
                        <span class="icon-contacts">
                            <i class="fa fa-2x fa-envelope-o"></i>
                        </span>
                    </div>
                    <div class="col-9">
                        <span class="title">E-mail</span>
                        <span class="desc-content">info@ulyssetour.com</span>
                    </div>

                    <div class="col-3 text-right">
                        <span class="icon-contacts">
                            <i class="fa fa-2x fa-phone"></i>
                        </span>
                    </div>
                    <div class="col-9">
                        <span class="title">{{$_lang->data->telephone}}</span>
                        <span class="desc-content">
                            <a href="tel:+998781501060" style="color: #fff">+998 78 150 10 60</a> <br>
                            <a href="tel:+998971553030" style="color: #fff">+998 97 155 30 30</a>
                        </span>
                    </div>

                    <div class="col-3 text-right">
                        <span class="icon-contacts">
                            <i class="fa fa-2x fa-map-marker"></i>
                        </span>
                    </div>
                    <div class="col-9">
                        <span class="title">{{$_lang->data->address}}</span>
                        <span class="desc-content">
                            {{$_lang->data->address_desc}}
                        </span>
                    </div>

                    <div class="col-3 text-right">
                        <span class="icon-contacts">
                            <i class="fa fa-2x fa-clock-o"></i>
                        </span>
                    </div>
                    <div class="col-9">
                        <span class="title">{{$_lang->data->opening_hours}}:</span>
                        <div class="desc-content">
                            <table class="table table-sm table-weather">
                                <tr>
                                    <td><span class="timeFrom"></span>-<span class="timeTo"></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-3 text-right">
                        <span class="icon-contacts">
                            <i class="fa fa-2x fa-dollar"></i>
                        </span>
                    </div>

                    <div class="col-9">
                        <span class="title">{{$_lang->data->change_currency}}:</span>
                        <div class="desc-content">
                            <p style="font-size: 18px; margin-bottom: 0"> 1 <i class="fa fa-dollar"></i> =
                                <span
                                        class="dollar_usz">0</span></p>
                            <p style="font-size: 18px; margin-bottom: 0"> 1 <i class="fa fa-euro"></i> =
                                <span
                                        class="dollar_eur">0</span></p>
                        </div>
                    </div>

                    <div class="col-3 text-right">
                        <span class="icon-contacts">
                            <i class="fa fa-2x fa-cloud" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="col-9">
                        <span class="title">{{$_lang->data->weather}}:</span>
                        <div class="desc-content">
                            <table class="table table-sm table-weather">
                                <tr>
                                    <td>{{$_lang->data->tashkent}}: <span class="wethTas"></span></td>
                                    <td>{{$_lang->data->samarkand}}: <span class="wethSam"></span></td>
                                </tr>
                                <tr>
                                    <td>{{$_lang->data->bukhara}}: <span class="wethBukh"></span></td>
                                    <td>{{$_lang->data->khiva}}: <span class="wethKhiw"></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="block-footer col-12">
    <div class="row">
        <div class="col-md-6 order-md-1 order-2">
            <p class="copyright">
                2018 © Ulysse Tour. All rights reserved. Design and development by <a
                        href="https://limitless.uz"
                        target="_blank">Limitless</a>.
            </p>
        </div>
        <div class="col-md-6 order-md-2 order-1">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9 text-md-left text-center">
                    <a href="https://www.instagram.com/ulyssetour/" target="_blank" class="social"><i
                                class="fa fa-instagram"></i></a>
                    <a href="https://www.facebook.com/ulyssetour" target="_blank" class="social"><i
                                class="fa fa-facebook"></i></a>
                    <a href="https://t.me/helinature" target="_blank" class="social"><i
                                class="fa fa-telegram"></i></a>
                    <a href="https://twitter.com/ulyssetour" target="_blank" class="social"><i
                                class="fa fa-twitter"></i></a>
                    <a href="https://vk.com/ulyssetour" target="_blank" class="social"><i
                                class="fa fa-vk"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

@if( isset($setting['request_tour']) && $setting['request_tour'])
    <!-- Modal -->
    <div class="modal fade" id="modalRequestTour" tabindex="-1" role="dialog"
         aria-labelledby="modalRequestTourTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRequestTourTitle">{{$_lang->data->request_tour}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" id="createTour">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="alert alert-success alert-message" style="display: none"
                                         role="alert">
                                        {{$_lang->data->data_message_send}}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input type="email" class="form-control" id="email"
                                               name="email" required="">
                                    </div>

                                    <div class="form-group">
                                        <label for="number_of_tourists_request">{{$_lang->data->number_of_tourists}}</label>
                                        <input type="text" class="form-control"
                                               id="number_of_tourists_request"
                                               name="number_of_tourists" required="">
                                    </div>

                                    <div class="form-group">
                                        <label for="category_request">{{$_lang->data->category}}</label>
                                        <select class="form-control" id="category_request" name="category">
                                            <option value="Все">{{$_lang->data->all}}</option>
                                            @foreach($_categories as $category)
                                                <option value="{{$category->title}}">{{$category->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="number_of_kids">{{$_lang->data->number_of_kids}}</label>
                                        <input type="text" class="form-control" id="number_of_kids"
                                               name="number_of_kids" required="">
                                    </div>

                                    @if($search['country'] == 1)
                                        <div class="form-group">
                                            <label for="city_request">{{$_lang->data->city}}</label>
                                            <select class="form-control selectMultiple" id="city_request"
                                                    name="city"
                                                    multiple="multiple">
                                                @foreach($_cities as $city)
                                                    <option value="{{$city->title}}">{{$city->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <label for="country_request">{{$_lang->data->country_name}}</label>
                                            <select class="form-control selectMultiple" id="country_request"
                                                    name="country"
                                                    multiple="multiple">
                                                <option value="Россия">{{$_lang->data->russia}}</option>
                                                <option value="Грузия">{{$_lang->data->georgia}}</option>
                                                <option value="Азербайджан">{{$_lang->data->azerbaijan}}</option>
                                                <option value="Армения">{{$_lang->data->armenia}}</option>
                                                <option value="Таджикистан">{{$_lang->data->tajikistan}}</option>
                                                <option value="Киргизия">{{$_lang->data->kyrgyzstan}}</option>
                                                <option value="Туркменистан">{{$_lang->data->turkmenistan}}</option>
                                                <option value="Афганистан">{{$_lang->data->afghanistan}}</option>
                                                <option value="Казахстан">{{$_lang->data->kazakhstan}}</option>
                                            </select>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-12" style="margin-bottom: 1rem">
                            <div class="row">
                                <div class="col-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input"
                                               id="visa_support"
                                               name="service" value="Визовая поддержка">
                                        <label class="custom-control-label"
                                               for="visa_support">{{$_lang->data->visa_support}}</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input"
                                               id="medical_insurance"
                                               name="service" value="Медицинская страховка">
                                        <label class="custom-control-label"
                                               for="medical_insurance">{{$_lang->data->medical_insurance}}</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    @if($search['country'] == 1)
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                   id="join_group"
                                                   name="service" value="Присоединиться к группе">
                                            <label class="custom-control-label"
                                                   for="join_group">{{$_lang->data->join_group}}</label>
                                        </div>
                                    @endif
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="air_tickets"
                                               name="service" value="Авиа билеты">
                                        <label class="custom-control-label"
                                               for="air_tickets">{{$_lang->data->air_tickets}}</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input"
                                               id="train_tickets"
                                               name="service" value="Ж/Д билеты">
                                        <label class="custom-control-label"
                                               for="train_tickets">{{$_lang->data->train_tickets}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="season_request">{{$_lang->data->season}}</label>
                                        <select class="form-control " id="season_request" name="season">
                                            @foreach($_seasons as $season)
                                                <option value="{{$season->title}}">{{$season->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="shooting_range_request">{{$_lang->data->shooting_range }}</label>
                                        <select class="form-control " id="shooting_range_request"
                                                name="shooting_range">
                                            <option value="Одноместный номер">{{$_lang->data->single_Room}}</option>
                                            <option value="Двуместный номер">{{$_lang->data->double_Room}}</option>
                                            <option value="Трехместный номер">{{$_lang->data->triple_room}}</option>
                                            <option value="Дополнительная кровать">{{$_lang->data->an_extra_bed}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="transport_request">{{$_lang->data->transports}}</label>
                                        <select class="form-control " id="transport_request"
                                                name="transport">
                                            <option value="Встречи и проводы на вокзалах и в аэропортах">{{$_lang->data->meeting_airports}}</option>
                                            <option value="Сопровождение на время экскурсий">{{$_lang->data->escort_excursions}}</option>
                                            <option value="Сопровождение на целый день">{{$_lang->data->escort_full_day}}</option>
                                            <option value="Перелеты на вертолете">{{$_lang->data->helicopter_flights}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_of_hotels">{{$_lang->data->category_of_hotels }}</label>
                                        <select class="form-control " id="category_of_hotels"
                                                name="category_of_hotels">
                                            <option value="Хостел">{{$_lang->data->hostel}}</option>
                                            <option value="Гостиница 3-4*">{{$_lang->data->hotel_3_4}}</option>
                                            <option value="Гостиница 4-5*">{{$_lang->data->hotel_4_5}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="food_request">{{$_lang->data->food}}</label>
                                        <select class="form-control " id="food_request" name="food">
                                            <option value="Завтраки в гостиницах">{{$_lang->data->breakfasts_in_hotels}}</option>
                                            <option value="Полупансион">{{$_lang->data->half_board}} </option>
                                            <option value="Полный пансион">{{$_lang->data->full_board}}</option>
                                            <option value="Вегетарианское меню">{{$_lang->data->vegetarian_menu}}</option>
                                            <option value="Халяльное меню">{{$_lang->data->halal_menu}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="guide_sevice_request">{{$_lang->data->guide_sevice}}</label>
                                        <select class="form-control " id="guide_sevice_request"
                                                name="guide_sevice">
                                            <option value="Локальные гиды на время экскурсий">{{$_lang->data->local_guides}}</option>
                                            <option value="Сопровождающий гид на весь маршрут">{{$_lang->data->accompanying_guides}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="sub_service_request">{{$_lang->data->additional_Information}}</label>
                                        <textarea name="sub_service" id="sub_service_request"
                                                  class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">{{$_lang->data->close}}</button>--}}
                    <button type="submit" form="createTour"
                            class="btn btn-primary"> {{$_lang->data->send_an_application}}</button>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="loader">
    <div class="image">
        <img src="{{asset('./images/logo.svg')}}" alt="logo">
    </div>
</div>

</body>
<!-- BEGIN JIVOSITE CODE {literal} -->
<script>
            {{date_default_timezone_set("Asia/Tashkent")}}
    let timeTashkent = new Date('{{date('Y-m-d H:i:s')}}');
</script>
<script type='text/javascript'>
    (function () {
        let widget_id = 'M0yJ0FsyDh';
        let d = document;
        let w = window;

        function l() {
            let s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = '//code.jivosite.com/script/widget/' + widget_id;
            let ss = document.getElementsByTagName('script')[0];
            ss.parentNode.insertBefore(s, ss);
        }

        if (d.readyState === 'complete') {
            l();
        } else {
            if (w.attachEvent) {
                w.attachEvent('onload', l);
            } else {
                w.addEventListener('load', l, false);
            }
        }
    })();</script>
<!-- {/literal} END JIVOSITE CODE -->
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWGLQj3o0123ler7QE_TaJam7j5H306ng&callback=initMap"></script>
</html>
