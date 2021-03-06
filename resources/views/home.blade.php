@extends('layouts.app')
@section('banner')
    <div id="carouselExampleControls" class="carousel slide wrap-text-on-slide" data-ride="carousel">
        <div class="carousel-inner text-on-slide">
            @foreach($banners as $key=>$banner)
                <div class="carousel-item carousel-hm @if($key === 0) active @endif"
                     style="background: url('{{$banner->image}}') center no-repeat; background-size: cover;">
                    {{--<img class="d-block w-100" src="{{$banner->image}}" alt="{{$banner->title}}">--}}
                    <div class="child">
                        <span class="sub-text">{{$banner->sub_title}}</span>
                        <span class="main-text">{{$banner->title}}</span>
                        @if($banner->link)
                            <a class="btn btn-primary" style="margin-top: 0.5rem"
                               href="{{$banner->link}}">{{$banner->name_link}}</a>
                        @endif
                    </div>
                    <div class="helper"></div>
                </div>
            @endforeach

        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="wrap-filter">
        <form class="col-12" action="/{{$_lang->title}}/tours" method="get">
            <div class="row">

                <div class="col-lg-3">
                    <div class="form-group row align-items-center">
                        <label for="from_filter" class="col-sm-3 col-form-label">{{$_lang->data->category}}</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control-sm" id="from_filter" name="category">
                                <option value="0">{{$_lang->data->all}}</option>
                                @foreach($_categories as $category)
                                    <option value="{{$category->id}}">{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group row align-items-center">
                        <label for="city_filter" class="col-sm-3 col-form-label">{{$_lang->data->city}}</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control-sm" id="city_filter" name="city">
                                <option value="0">{{$_lang->data->all}}</option>
                                @foreach($_cities as $city)
                                    <option value="{{$city->id}}">{{$city->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group row align-items-center">
                        <label for="season_filter" class="col-sm-3 col-form-label">{{$_lang->data->season}}</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control-sm" id="season_filter" name="season">
                                <option value="0">{{$_lang->data->all}}</option>
                                @foreach($_seasons as $item)
                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="join_the_group"
                                   name="join_the_group" value="1">
                            <label class="custom-control-label"
                                   for="join_the_group">{{$_lang->data->join_the_group}}</label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-1 block-btn">
                    <button type="submit" class="btn-filter">{{$_lang->data->search}}</button>
                </div>

            </div>
        </form>
    </div>

    @if(count($hotTours))
        <div class="block-content container" id="hot-tours">
            <div class="col-12 title-block">
                <span class="title">{{$_lang->data->hot}}</span>
                <span class="sub">{{$_lang->data->offers}}</span>
            </div>

            <div class="col-12 hot-offers owl-carousel owl-theme">
                @foreach($hotTours as $tour)
                    <div class="block-card">
                        <div class="image"
                             style="background: var(--greyColor) url({{asset($tour->image)}}) center no-repeat;
                                     background-size: cover;"></div>
                        <div class="col-12 content">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <span class="title-content">{{$tour->title}}</span>
                                </div>
                                <div class="col-10">
                                    <div class="desc-content">
                                        <p class="blackColor">{{$tour->category_title}}</p>
                                        <p class="blackColor">
                                            <i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime(date($tour->hot)))}}
                                        </p>
                                        <p>
                                            <i class="fa fa-map-marker"></i>
                                            <span class="blackColor">
                                           @foreach($tour->city_title as $key=>$city)
                                                    {{$city}}@if($key !== count($tour->city_title)-1),@endif
                                                @endforeach
                                    </span>
                                        </p>
                                        <p>{{$_lang->data->season}}: <span
                                                    class="blackColor">{{$tour->season_title}}</span></p>
                                        <p>{{$_lang->data->durations}}: <span
                                                    class="blackColor">{{$tour->duration}}</span></p>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <a href="/{{$_lang->title}}/hot-tour/{{$tour->id}}/{{$tour->url}}"><img
                                                src="{{asset('./images/arrow-right.svg')}}" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="block-content block-sub-image" id="tours">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-lg-12 col-md-9">
                    <div class="block-tours owl-carousel owl-theme">

                        <div class="row">
                            <div class="col-12">
                                <a href="/{{$_lang->title}}/tours/{{$_tags['tours-1'][0]->user_url}}?country=1"
                                   class=" title-block">
                                    <span class="sub">{{$_lang->data->tours}}</span>
                                    <span class="title">{{$_lang->data->inUzbekistan}}</span>
                                </a>
                            </div>

                            @foreach($uzTours as $tour)
                                <div class="block-tour index row align-items-end">
                                    <div class="col-4 image"
                                         style="background: var(--greyColor) url({{asset($tour->image)}}) center no-repeat;
                                                 background-size: cover;"
                                    ></div>
                                    <div class="col-7">
                                        <span class="title">{{$tour->title}}</span>
                                        <div class="desc-content">
                                            <p class="blackColor">{{$tour->category_title}}</p>
                                            <p>
                                                <i class="fa fa-map-marker"></i>
                                                <span class="blackColor">
                                                    @foreach($tour->city_title as $key=>$city)
                                                        {{$city}}@if($key !== count($tour->city_title)-1),@endif
                                                    @endforeach
                                                </span>
                                            </p>
                                            <p>{{$_lang->data->season}}: <span
                                                        class="blackColor">{{$tour->season_title}}</span></p>
                                            <p>{{$_lang->data->durations}}: <span
                                                        class="blackColor">{{$tour->duration}}</span></p>
                                            <p>&nbsp;</p>
                                        </div>
                                    </div>
                                    <div class="col-1 action">
                                        <a href="/{{$_lang->title}}/tour/{{$tour->id}}/{{$tour->url}}"><img
                                                    src="{{asset('./images/arrow-right.svg')}}" alt=""></a>
                                    </div>
                                </div>
                            @endforeach

                        </div>


                        <div class="row">
                            <div class="col-12">
                                <a href="/{{$_lang->title}}/tours/{{$_tags['tours-0'][0]->user_url}}?country=0"
                                   class=" title-block text-right">
                                    <span class="sub">{{$_lang->data->tours}}</span>
                                    <span class="title">{{$_lang->data->inCentralAsia}}</span>
                                </a>
                            </div>

                            @foreach($sATours as $tour)
                                <div class="block-tour index row align-items-end">
                                    <div class="col-4 image"
                                         style="background: var(--greyColor) url({{asset($tour->image)}}) center no-repeat;
                                                 background-size: cover;"
                                    ></div>
                                    <div class="col-7">
                                        <span class="title">{{$tour->title}}</span>
                                        <div class="desc-content">
                                            <p class="blackColor">{{$tour->category_title}}</p>
                                            <p>
                                                <i class="fa fa-map-marker"></i>
                                                <span class="blackColor">
                                                    @foreach($tour->city_title as $key=>$city)
                                                        {{$city}}@if($key !== count($tour->city_title)-1),@endif
                                                    @endforeach
                                                </span>
                                            </p>
                                            <p>{{$_lang->data->season}}: <span
                                                        class="blackColor">{{$tour->season_title}}</span></p>
                                            @if($tour->duration_title)
                                                <p>{{$_lang->data->durations}}: <span
                                                            class="blackColor">{{$tour->duration_title}}</span></p>
                                            @else
                                                <p>&nbsp;</p>
                                            @endif
                                            <p>&nbsp;</p>
                                        </div>
                                    </div>
                                    <div class="col-1 action">
                                        <a href="/{{$_lang->title}}/tour/{{$tour->id}}/{{$tour->url}}"><img
                                                    src="{{asset('./images/arrow-right.svg')}}" alt=""></a>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=" container">
        <div class="row">
            <div class="col-12 block-pluses owl-carousel owl-theme">

                <div class="block-plus">
                    <div class="image">
                        <img src="{{asset('./images/selection.svg')}}" alt="{{$_lang->data->pluses[0]->title}}">
                    </div>
                    <div class="title">
                        {{$_lang->data->pluses[0]->title}}
                    </div>
                    <div class="desc-content">
                        {{$_lang->data->pluses[0]->description}}
                    </div>
                </div>

                <div class="block-plus">
                    <div class="image">
                        <img src="{{asset('./images/team.svg')}}" alt="{{$_lang->data->pluses[1]->title}}">
                    </div>
                    <div class="title">
                        {{$_lang->data->pluses[1]->title}}
                    </div>
                    <div class="desc-content">
                        {{$_lang->data->pluses[1]->description}}
                    </div>
                </div>

                <div class="block-plus">
                    <div class="image">
                        <img src="{{asset('./images/service.svg')}}" alt="{{$_lang->data->pluses[2]->title}}">
                    </div>
                    <div class="title">
                        {{$_lang->data->pluses[2]->title}}
                    </div>
                    <div class="desc-content">
                        {{$_lang->data->pluses[2]->description}}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-12 block-image-top" id="about-us">
        <div class="block-about-us container">
            <div class="row justify-content-md-center">
                <div class="col-md-10">
                    <div class="title">Ulysse Tour</div>
                    <div class="desc-content">
                        {!! $_lang->data->aboutus !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="block-content container" id="news">
        <div class=" title-block text-center">
            <span class="title-single">{{$_lang->data->news}}</span>
        </div>
        <div class="block-news owl-carousel owl-theme">

            @foreach($_news as $item)
                <div class="block-news-once">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-5">
                                <img src="{{$item->image}}" alt="{{$item->title}}">
                                {{--<span class="title-data">15</span>--}}
                                {{--<span class="title-mouth">Июля</span>--}}
                            </div>
                            <div class="col-7 text-center">
                            <span class="title">
                            {{$item->title}}
                            </span>
                            </div>
                            <div class="col-12">
                                <p class="desc-content">{{$item->min_description}}</p>
                            </div>
                            <div class="col-12">
                                <a href="/{{$_lang->title}}/news/{{$item->id}}/{{$item->url}}" class="btn btn-primary">
                                    {{$_lang->data->read_more}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
@endsection
