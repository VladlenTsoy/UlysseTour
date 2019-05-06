@extends('layouts.app')

@section('content')
    <div class="block-content container">
        <div class="col-12">
            <div class="row">
                @if(!isset($helinature))
                    <div class="col-md-4 tours-filter-block">
                        <form method="get">
                            @if( isset($country) && $country !== null)
                                <input type="hidden" name="country" hidden value="{{$country}}">
                            @endif
                            <div class="form-group row">
                                <label for="from_filter"
                                       class="col-sm-3 col-form-label">{{$_lang->data->category}}</label>
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
                                <label for="category_filter"
                                       class="col-sm-3 col-form-label">{{$_lang->data->city}}</label>
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
                                <label for="season_filter"
                                       class="col-sm-3 col-form-label">{{$_lang->data->season}}</label>
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
                                    <label class="custom-control-label"
                                           for="joinTheGroup1">{{$_lang->data->yes}}</label>
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
                @else
                    <div class="col-md-4">
                        <div>
                            {!! $_lang->data->helinature_text !!}
                        </div>

                        <button type="button" data-toggle="modal" data-target="#modalSchedule"
                                class="btn btn-warning btn-block">
                            {{$_lang->data->schedule}}
                        </button>
                    </div>
                @endif
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

    @if(isset($helinature))
        <div class="modal fade bd-example-modal-lg" id="modalSchedule" tabindex="-1" role="dialog"
             aria-labelledby="modal"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal">{{$_lang->data->schedule}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 0">
                        <table class="table table-bordered table-responsive-md table-helicopter">
                            <thead class="thead-dark">
                            <th>{{$_lang->data->dates}}</th>
                            <th>{{$_lang->data->title}}</th>
                            <th>{{$_lang->data->place}}</th>
                            <th>{{$_lang->data->cost}}</th>
                            <th>{{$_lang->data->number_of_tourists}}</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach($helicopters as $helicopter)
                                <tr>
                                    <td class="nowrap">{{ Carbon\Carbon::parse($helicopter->date)->format('d-m-Y')}}</td>
                                    <td>{{$helicopter->title}}</td>
                                    <td>{{$helicopter->place}}</td>
                                    <td>{{$helicopter->cost}}</td>
                                    <td>{{$helicopter->max_qty_tourists}}</td>
                                    <td>
                                        <a href="" data-toggle="modal"
                                           data-target="#modalBookItHelinature" data-whatever="{{$helicopter->id}}">{{$_lang->data->book_it}}</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{$_lang->data->close}}</button>
                    </div>
                </div>
            </div>
        </div>

        {{----}}
        <div class="modal fade bd-example-modal-lg" id="modalBookItHelinature" tabindex="-1" role="dialog" aria-labelledby="modal"
             aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal">{{$_lang->data->book_it}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="book_it_form_helicopter">
                            <div class="row">
                                <div class="col-12">
                                    <div class="alert alert-success alert-message" style="display: none" role="alert">
                                        {{$_lang->data->data_message_send}}
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <input type="hidden" hidden value="ВЕРТОЛЕТНЫЕ ТУРЫ" name="category">
                                    <input type="hidden" hidden class="helicopter_id" value="" name="helicopter_id">

                                    <div class="form-group">
                                        <label for="first_name">{{$_lang->data->first_name}}</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">{{$_lang->data->email}}</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="citizenship">{{$_lang->data->citizenship}}</label>
                                        <input type="text" class="form-control" id="citizenship" name="citizenship"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label for="number_of_tourists">{{$_lang->data->number_of_tourists}}</label>
                                        <input type="text" class="form-control" id="number_of_tourists"
                                               name="number_of_tourists" required>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">{{$_lang->data->last_name}}</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="cellphone">{{$_lang->data->cellphone}}</label>
                                        <input type="text" class="form-control" id="cellphone" name="cellphone" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="number_of_kids">{{$_lang->data->number_of_kids}}</label>
                                        <input type="text" class="form-control" id="number_of_kids" name="number_of_kids"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label for="dates">{{$_lang->data->dates}}</label>
                                        <input type="date" class="form-control" id="dates" name="dates" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="additional_info">{{$_lang->data->additional_info}}</label>
                                        <textarea name="additional_info" id="additional_info"
                                                  class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-primary btn-block" form="book_it_form_helicopter"
                                            type="submit">{{$_lang->data->book_it}}</button>
                                    <br>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-secondary btn-block"
                                            data-dismiss="modal">{{$_lang->data->close}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
