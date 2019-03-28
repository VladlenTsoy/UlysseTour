@extends('layouts.app')

@section('content')
    <div class="block-content container">
        <div class="col-12">
            <div class="row">
                <div class="col-md-4 tours-filter-block">
                    <form method="get">
                        @if( isset($country) && $country !== null)
                            <input type="hidden" name="country" hidden value="{{$country}}">
                        @endif
                        <div class="form-group row">
                            <label for="from_filter" class="col-sm-3 col-form-label">{{$_lang->data->category}}</label>
                            <div class="col-sm-9">
                                <select class="form-control " id="from_filter" name="category">
                                    <option value="0">{{$_lang->data->all}}</option>
                                    @foreach($_categories as $category)
                                        <option value="{{$category->id}}"
                                                @if(isset($search['category']) && $search['category'] == $category->id) selected @endif>{{$category->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category_filter" class="col-sm-3 col-form-label">{{$_lang->data->city}}</label>
                            <div class="col-sm-9">
                                <select class="form-control " id="category_filter" name="city">
                                    <option value="0">{{$_lang->data->all}}</option>
                                    @foreach($_cities as $city)
                                        <option value="{{$city->id}}"
                                                @if(isset($search['city']) && $search['city'] == $city->id) selected @endif>{{$city->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="season_filter" class="col-sm-3 col-form-label">{{$_lang->data->season}}</label>
                            <div class="col-sm-9">
                                <select class="form-control " id="season_filter" name="season">
                                    <option value="0">{{$_lang->data->all}}</option>
                                    @foreach($_seasons as $season)
                                        <option value="{{$season->id}}"
                                                @if(isset($search['season']) && $search['season'] == $season->id) selected @endif>{{$season->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{--<div cl/ass="form-group row">--}}
                        {{--<div class="col-sm-12">--}}
                        {{--<select class="form-control ">--}}
                        {{--<option>Фильтрация</option>--}}
                        {{--</select>--}}
                        {{--</div>--}}
                        {{--</div>--}}

                        <div class="form-group">
                            <p>{{$_lang->data->join_group}}</p>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="joinTheGroup1" name="join_the_group"
                                       class="custom-control-input" value="1"
                                       @if( isset($search['join_group']) && $search['join_group'] == 1 ) checked @endif
                                >
                                <label class="custom-control-label" for="joinTheGroup1">{{$_lang->data->yes}}</label>
                            </div>

                            <div class="custom-control custom-radio">
                                <input type="radio" id="joinTheGroup2" name="join_the_group"
                                       class="custom-control-input" value="2"
                                       @if( isset($search['join_group']) && $search['join_group'] == 2 ) checked @endif
                                >
                                <label class="custom-control-label" for="joinTheGroup2">{{$_lang->data->no}}</label>
                            </div>

                            <div class="custom-control custom-radio">
                                <input type="radio" id="joinTheGroup3" name="join_the_group"
                                       class="custom-control-input" value="0"
                                       @if( !isset($search['join_group']) ) checked @endif
                                >
                                <label class="custom-control-label"
                                       for="joinTheGroup3">{{$_lang->data->irrelevant}}</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">{{$_lang->data->search}}</button>
                    </form>
                </div>
                <div class="col-md-8">

                    @foreach($tours as $tour)
                        <div class="block-tour row align-items-end">
                            <div class="col-4 image"
                                 style="background: var(--greyColor) url({{asset($tour->image)}}) center no-repeat;
                                         background-size: cover;"></div>
                            <div class="col-7">
                                @if(isset($hot))
                                    <span class="title" style="display: block;">{{$tour->title}}</span>
                                @else
                                    <span class="title">{{$tour->title}}</span>
                                @endif
                                <div class="desc-content">
                                    <p class="blackColor">{{$tour->category_title}}</p>
                                    @if(isset($hot))
                                        <p>
                                            <i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime(date($tour->hot)))}}
                                        </p>
                                    @endif
                                    <p><i class="fa fa-map-marker"></i>
                                        <span class="blackColor">
                                             @foreach($tour->city_title as $key=>$city)
                                                {{$city}}@if($key !== count($tour->city_title)-1),@endif
                                            @endforeach
                                        </span>
                                    </p>
                                    <p>{{$_lang->data->season}}: <span class="blackColor">{{$tour->season_title}}</span>
                                    </p>
                                    <p>{{$_lang->data->durations}}: <span
                                                class="blackColor">{{$tour->duration}}</span></p>
                                </div>
                            </div>
                            <div class="col-1 action">
                                <a href="/{{$_lang->title}}/{{$setting['link'] ?? 'tour'}}/{{$tour->id}}/{{$tour->url}}"><img
                                            src="{{asset('./images/arrow-right.svg')}}" alt="" width="25px"></a>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

@endsection
