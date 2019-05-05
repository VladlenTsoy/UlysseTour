@extends('layouts.app')

@section('content')
    <div class="block-content container">
        <div class="col-12 details-tour">
            <div class="row">
                <div class="col-md-7">
                    <span class="title-block">{{$_lang->data->information}}</span>
                    <table class="table table-sm">
                        <tr>
                            <td class="title">{{$_lang->data->durations}}</td>
                            <td class="desc">{{$tour->duration}}</td>
                        </tr>
                        <tr>
                            <td class="title">{{$_lang->data->category}}</td>
                            <td class="desc">{{$tour->category_title}}</td>
                        </tr>
                        @if(isset($hot))
                            <tr>
                                <td class="title">{{$_lang->data->hot_date}}</td>
                                <td class="desc">{{ date('d-m-Y', strtotime(date($tour->hot)))}}</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="title">{{$_lang->data->cities}}</td>
                            <td class="desc">
                                @foreach($tour->city_title as $key => $city)
                                    {{$city}}@if($key !== count($tour->city_title)-1),@endif
                                @endforeach
                            </td>
                        </tr>

                        <tr>
                            <td class="title">{{$_lang->data->season}}</td>
                            <td class="desc">{{$tour->season_title}}</td>
                        </tr>

                        <tr>
                            <td class="title">{{$_lang->data->count_people}}</td>
                            <td class="desc">{{$tour->max_qty_tourists}}</td>
                        </tr>

                        <tr>
                            <td class="title">{{$_lang->data->cost}}</td>
                            <td class="desc">{{$tour->cost}}$</td>
                        </tr>
                    </table>

                    <div class="block-btn-cost row">
                        @if($tour->helicopter === 0)
                            <div class="col-md-6 text-right">
                                <button class="btn btn-warning" data-toggle="modal" data-target="#modalSchedule">
                                    <i class="fa fa-plane"></i> {{$_lang->data->schedule}}
                                </button>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <button class="btn btn-primary" data-toggle="modal"
                                    data-target="#modalBookIt">{{$_lang->data->book_it}}</button>
                        </div>
                    </div>

                </div>
                <div class="col-md-5">
                    @if(count($tour->route) === 1)
                        <div class="map-block-tour-route" id="map-marker"></div>
                    @else
                        <div class="map-block-tour-route" id="map-route"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="block-content block-mini-desc">
        <div class="container">
            <span class="title">{{$_lang->data->description}}</span>
            <div class="desc-content">
                {!! str_replace("&nbsp;", ' ', $tour->description) !!}
            </div>
        </div>
    </div>

    <div class="block-content block-programs">
        <div class="container">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6">
                        <span class="title">{{$_lang->data->program_tour}}</span>
                    </div>
                    <div class="col-md-6 text-right">
                        <a class="sub-option-program openall"
                           href="javascript:openAllProgram(true)">{{$_lang->data->open_all}}</a>
                        <a class="sub-option-program closeall" style="display: none"
                           href="javascript:openAllProgram(false)">{{$_lang->data->close_all}}</a>
                    </div>
                </div>
            </div>

            <div class="accordion accordion-programs-block">
                @foreach($tour->program as $key=>$item)
                    <div class="card">
                        <div class="card-header" id="heading-{{$key+1}}">
                            <h5 class="mb-0">
                                <button class="btn btn-link trigger collapsed" type="button" data-toggle="collapse"
                                        data-target="#collapse-{{$key+1}}" aria-expanded="false"
                                        aria-controls="collapse-{{$key+1}}">
                                    {{$_lang->data->day}} {{$key+1}} : {{$item->title}}
                                </button>
                            </h5>
                        </div>
                        <div id="collapse-{{$key+1}}" class="collapse multi-collapse"
                             aria-labelledby="heading-{{$key+1}}">
                            <div class="card-body">
                                {!! str_replace("&nbsp;", ' ', $item->description) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="block-content block-mini-desc">
        <div class="container">
            <div class="col-12">
                <div class="row">

                    <div class="col-md-6">
                        <span class="title text-center">{{$_lang->data->include}}:</span>
                        <div class="desc-content row" style="font-size: 16px">
                            @foreach($tour->include_service_title as $item)
                                <div class="col-12">- {{$item}};</div>
                            @endforeach
                            @if(count($transports) !== 0)
                                <div class="col-12">- <a href="javascript:void(0)" data-toggle="modal"
                                                         data-target="#modalTransport">{{$_lang->data->transports}}</a>;
                                </div>
                            @endif
                            @if(count($guideService) !== 0)
                                <div class="col-12">- <a href="javascript:void(0)" data-toggle="modal"
                                                         data-target="#modalGuideService">{{$_lang->data->guide_sevice}}</a>;
                                </div>
                            @endif
                            @if(count($food) !== 0)
                                <div class="col-12">- <a href="javascript:void(0)" data-toggle="modal"
                                                         data-target="#modalFood">{{$_lang->data->food}}</a>;
                                </div>
                            @endif
                            @if(count($accommodations) !== 0)
                                <div class="col-12">- <a href="javascript:void(0)" data-toggle="modal"
                                                         data-target="#modalAccommodations">{{$_lang->data->accommodations}}</a>;
                                </div>
                            @endif

                            {{--                            @foreach($tour->include_service_title as $item)--}}
                            {{--<div class="col-md-6">{{$item}}</div>--}}
                            {{--@endforeach--}}
                            {{--                            @foreach($tour->include_guide_title as $item)--}}
                            {{--<div class="col-md-6">{{$item}}</div>--}}
                            {{--@endforeach--}}
                            {{--                            @foreach($tour->include_food_title as $item)--}}
                            {{--<div class="col-md-6">{{$item}}</div>--}}
                            {{--@endforeach--}}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <span class="title text-center">{{$_lang->data->sub_service}}:</span>
                        <div class="desc-content" style="font-size: 16px">
                            @foreach($tour->ad_service_title as $item)
                                <div>- {{$item}};</div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    @if($tour->conditions)
        <div class="block-content block-programs">
            <div class="container">
                <span class="title">{{$_lang->data->conditions}}</span>
                <div class="desc-content" style="font-size: 16px">
                    {!! str_replace("&nbsp;", ' ', $tour->conditions) !!}
                </div>
            </div>
        </div>
    @endif

    <div class="container">
        <hr>
        <div id="disqus_thread"></div>
        <script>

            /**
             *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
             *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
            /*
            var disqus_config = function () {
            this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
            this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
            };
            */
            (function () { // DON'T EDIT BELOW THIS LINE
                var d = document, s = d.createElement('script');
                s.src = 'https://ulyssetour-com.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by
                Disqus.</a></noscript>

    </div>

    {{----}}
    <div class="modal fade bd-example-modal-lg" id="modalTransport" tabindex="-1" role="dialog"
         aria-labelledby="modalTransportTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTransportTitle">{{$_lang->data->transports}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach($transports as $transport)
                        <h4>{{$transport->title}}</h4>
                        {!! str_replace("&nbsp;", ' ', $transport->description) !!}
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{$_lang->data->close}}</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>

    {{----}}
    <div class="modal fade bd-example-modal-lg" id="modalGuideService" tabindex="-1" role="dialog"
         aria-labelledby="modalGuideServiceTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalGuideServiceTitle">{{$_lang->data->guide_sevice}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach($guideService as $value)
                        <h4>{{$value->title}}</h4>
                        {!! str_replace("&nbsp;", ' ', $value->description) !!}
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{$_lang->data->close}}</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>

    {{----}}
    <div class="modal fade bd-example-modal-lg" id="modalAccommodations" tabindex="-1" role="dialog"
         aria-labelledby="modalAccommodationsTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAccommodationsTitle">{{$_lang->data->accommodations}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach($accommodations as $val)
                        <h4>{{$val->title}}</h4>
                        {!! str_replace("&nbsp;", ' ', $val->description) !!}
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{$_lang->data->close}}</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>

    {{----}}
    <div class="modal fade bd-example-modal-lg" id="modalFood" tabindex="-1" role="dialog"
         aria-labelledby="modalFoodTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFoodTitle">{{$_lang->data->food}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach($food as $val)
                        <h4>{{$val->title}}</h4>
                        {!! str_replace("&nbsp;", ' ', $val->description) !!}
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{$_lang->data->close}}</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>

    {{----}}
    <div class="modal fade bd-example-modal-lg" id="modalBookIt" tabindex="-1" role="dialog" aria-labelledby="modal"
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
                    <form id="book_it_form">
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-success alert-message" style="display: none" role="alert">
                                    {{$_lang->data->data_message_send}}
                                </div>
                            </div>
                            <div class="col-md-6">

                                <input type="hidden" hidden value="{{$tour->id}}" name="id">

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
                                    <label for="preference_for_food">{{$_lang->data->preference_for_food}}</label>
                                    <select name="preference_for_food" id="preference_for_food" class="form-control"
                                            required>
                                        @foreach($food_sub as $value)
                                            <option value="{{$value->title}}">{{$value->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="room_share">{{$_lang->data->room_share}}</label>
                                    <textarea name="room_share" id="room_share" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                                <button class="btn btn-primary btn-block" form="book_it_form"
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

    {{----}}
    <div class="modal fade bd-example-modal-lg" id="modalSchedule" tabindex="-1" role="dialog" aria-labelledby="modal"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal">{{$_lang->data->schedule}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12 wrap-rasp-form">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="from_schedule" class="secondGreyColor">{{$_lang->data->from}}</label>
                                    <select name="" class="form-control form-control-sm" id="from_schedule">
                                        <optgroup label="">
                                            <option value="c10335" selected="">{{$_lang->data->c10335}}</option>
                                            <option value="c10336">{{$_lang->data->c10336}}</option>
                                            <option value="c10330">{{$_lang->data->c10330}}</option>
                                            <option value="c10331">{{$_lang->data->c10331}}</option>
                                            <option value="c21314">{{$_lang->data->c21314}}</option>
                                            <option value="c10296">{{$_lang->data->c10296}}</option>
                                            <option value="c10337">{{$_lang->data->c10337}}</option>
                                            <option value="c10334">{{$_lang->data->c10334}}</option>
                                            <option value="c10338">{{$_lang->data->c10338}}</option>
                                            <option value="c21105">{{$_lang->data->c21105}}</option>
                                        </optgroup>
                                        <optgroup label="">
                                            <option value="c11508">{{$_lang->data->c11508}}</option>
                                            <option value="c10562">{{$_lang->data->c10562}}</option>
                                            <option value="c10604">{{$_lang->data->c10604}}</option>
                                            <option value="c213">{{$_lang->data->c213}}</option>
                                            <option value="c10445">{{$_lang->data->c10445}}</option>
                                            <option value="c131">{{$_lang->data->c131}}</option>
                                            <option value="c26816">{{$_lang->data->c26816}}</option>
                                            <option value="c10620">{{$_lang->data->c10620}}</option>
                                            <option value="c10590">{{$_lang->data->c10590}}</option>
                                            <option value="c11499">{{$_lang->data->c11499}}</option>
                                            <option value="c10616">{{$_lang->data->c10616}}</option>
                                            <option value="c202">{{$_lang->data->c202}}</option>
                                            <option value="c10635">{{$_lang->data->c10635}}</option>
                                            <option value="c10594">{{$_lang->data->c10594}}</option>
                                            <option value="c100">{{$_lang->data->c100}}</option>
                                            <option value="c10393">{{$_lang->data->c10393}}</option>
                                            <option value="c10502">{{$_lang->data->c10502}}</option>
                                            <option value="c20843">{{$_lang->data->c20843}}</option>
                                            <option value="c10448">{{$_lang->data->c10448}}</option>
                                            <option value="c10619">{{$_lang->data->c10619}}</option>
                                        </optgroup>
                                        <optgroup label="">
                                            <option value="c22177">{{$_lang->data->c22177}}</option>
                                            <option value="c10318">{{$_lang->data->c10318}}</option>
                                            <option value="c62">{{$_lang->data->c62}}</option>
                                            <option value="c39">{{$_lang->data->c39}}</option>
                                            <option value="c55">{{$_lang->data->c55}}</option>
                                            <option value="c163">{{$_lang->data->c163}}</option>
                                            <option value="c54">{{$_lang->data->c54}}</option>
                                            <option value="c35">{{$_lang->data->c35}}</option>
                                            <option value="c2">{{$_lang->data->c2}}</option>
                                            <option value="c172">{{$_lang->data->c172}}</option>
                                            <option value="c10253">{{$_lang->data->c10253}}</option>
                                            <option value="c22">{{$_lang->data->c22}}</option>
                                            <option value="c11063">{{$_lang->data->c11063}}</option>
                                            <option value="c51">{{$_lang->data->c51}}</option>
                                            <option value="c193">{{$_lang->data->c193}}</option>
                                            <option value="c10309">{{$_lang->data->c10309}}</option>
                                            <option value="c43">{{$_lang->data->c43}}</option>
                                            <option value="c157">{{$_lang->data->c157}}</option>
                                            <option value="c65">{{$_lang->data->c65}}</option>
                                            <option value="c239">{{$_lang->data->c239}}</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="to_schedule" class="secondGreyColor">{{$_lang->data->to}}</label>
                                    <select name="" class="form-control form-control-sm" id="to_schedule">
                                        <optgroup label="">
                                            <option @if($tour->schedule === 'c10335') selected @endif value="c10335">
                                                {{$_lang->data->c10335}}
                                            </option>
                                            <option @if($tour->schedule === 'c10336') selected @endif value="c10336">
                                                {{$_lang->data->c10336}}
                                            </option>
                                            <option @if($tour->schedule === 'c10330') selected @endif value="c10330">
                                                {{$_lang->data->c10330}}
                                            </option>
                                            <option @if($tour->schedule === 'c10331') selected @endif value="c10331">
                                                {{$_lang->data->c10331}}
                                            </option>
                                            <option @if($tour->schedule === 'c21314') selected @endif value="c21314">
                                                {{$_lang->data->c21314}}
                                            </option>
                                            <option @if($tour->schedule === 'c10296') selected @endif value="c10296">
                                                {{$_lang->data->c10296}}
                                            </option>
                                            <option @if($tour->schedule === 'c10337') selected @endif value="c10337">
                                                {{$_lang->data->c10337}}
                                            </option>
                                            <option @if($tour->schedule === 'c10334') selected @endif value="c10334">
                                                {{$_lang->data->c10334}}
                                            </option>
                                            <option @if($tour->schedule === 'c10338') selected @endif value="c10338">
                                                {{$_lang->data->c10338}}
                                            </option>
                                            <option @if($tour->schedule === 'c21105') selected @endif value="c21105">
                                                {{$_lang->data->c21105}}
                                            </option>
                                        </optgroup>
                                        <optgroup label="">
                                            <option @if($tour->schedule === 'c11508') selected @endif value="c11508">
                                                {{$_lang->data->c11508}}
                                            </option>
                                            <option @if($tour->schedule === 'c10562') selected @endif value="c10562">
                                                {{$_lang->data->c10562}}
                                            </option>
                                            <option @if($tour->schedule === 'c10604') selected @endif value="c10604">
                                                {{$_lang->data->c10604}}
                                            </option>
                                            <option @if($tour->schedule === 'c213') selected @endif value="c213">
                                                {{$_lang->data->c213}}
                                            </option>
                                            <option @if($tour->schedule === 'c10445') selected @endif value="c10445">
                                                {{$_lang->data->c10445}}
                                            </option>
                                            <option @if($tour->schedule === 'c131') selected @endif value="c131">
                                                {{$_lang->data->c131}}
                                            </option>
                                            <option @if($tour->schedule === 'c26816') selected @endif value="c26816">
                                                {{$_lang->data->c26816}}
                                            </option>
                                            <option @if($tour->schedule === 'c10620') selected @endif value="c10620">
                                                {{$_lang->data->c10620}}
                                            </option>
                                            <option @if($tour->schedule === 'c10590') selected @endif value="c10590">
                                                {{$_lang->data->c10590}}
                                            </option>
                                            <option @if($tour->schedule === 'c11499') selected @endif value="c11499">
                                                {{$_lang->data->c11499}}
                                            </option>
                                            <option @if($tour->schedule === 'c10616') selected @endif value="c10616">
                                                {{$_lang->data->c10616}}
                                            </option>
                                            <option @if($tour->schedule === 'c202') selected @endif value="c202">
                                                {{$_lang->data->c202}}
                                            </option>
                                            <option @if($tour->schedule === 'c10635') selected @endif value="c10635">
                                                {{$_lang->data->c10635}}
                                            </option>
                                            <option @if($tour->schedule === 'c10594') selected @endif value="c10594">
                                                {{$_lang->data->c10594}}
                                            </option>
                                            <option @if($tour->schedule === 'c100') selected @endif value="c100">
                                                {{$_lang->data->c100}}
                                            </option>
                                            <option @if($tour->schedule === 'c10393') selected @endif value="c10393">
                                                {{$_lang->data->c10393}}
                                            </option>
                                            <option @if($tour->schedule === 'c10502') selected @endif value="c10502">
                                                {{$_lang->data->c10502}}
                                            </option>
                                            <option @if($tour->schedule === 'c20843') selected @endif value="c20843">
                                                {{$_lang->data->c20843}}
                                            </option>
                                            <option @if($tour->schedule === 'c10448') selected @endif value="c10448">
                                                {{$_lang->data->c10448}}
                                            </option>
                                            <option @if($tour->schedule === 'c10619') selected @endif value="c10619">
                                                {{$_lang->data->c10619}}
                                            </option>
                                        </optgroup>
                                        <optgroup label="">
                                            <option @if($tour->schedule === 'c22177') selected @endif value="c22177">
                                                {{$_lang->data->c22177}}
                                            </option>
                                            <option @if($tour->schedule === 'c10318') selected @endif value="c10318">
                                                {{$_lang->data->c10318}}
                                            </option>
                                            <option @if($tour->schedule === 'c62') selected @endif value="c62">
                                                {{$_lang->data->c62}}
                                            </option>
                                            <option @if($tour->schedule === 'c39') selected @endif value="c39">
                                                {{$_lang->data->c39}}
                                            </option>
                                            <option @if($tour->schedule === 'c55') selected @endif value="c55">
                                                {{$_lang->data->c55}}
                                            </option>
                                            <option @if($tour->schedule === 'c163') selected @endif value="c163">
                                                {{$_lang->data->c163}}
                                            </option>
                                            <option @if($tour->schedule === 'c54') selected @endif value="c54">
                                                {{$_lang->data->c54}}
                                            </option>
                                            <option @if($tour->schedule === 'c35') selected @endif value="c35">
                                                {{$_lang->data->c35}}
                                            </option>
                                            <option @if($tour->schedule === 'c2') selected @endif value="c2">
                                                {{$_lang->data->c2}}
                                            </option>
                                            <option @if($tour->schedule === 'c172') selected @endif value="c172">
                                                {{$_lang->data->c172}}
                                            </option>
                                            <option @if($tour->schedule === 'c10253') selected @endif value="c10253">
                                                {{$_lang->data->c10253}}
                                            </option>
                                            <option @if($tour->schedule === 'c22') selected @endif value="c22">
                                                {{$_lang->data->c22}}
                                            </option>
                                            <option @if($tour->schedule === 'c11063') selected @endif value="c11063">
                                                {{$_lang->data->c11063}}
                                            </option>
                                            <option @if($tour->schedule === 'c51') selected @endif value="c51">
                                                {{$_lang->data->c51}}
                                            </option>
                                            <option @if($tour->schedule === 'c193') selected @endif value="c193">
                                                {{$_lang->data->c193}}
                                            </option>
                                            <option @if($tour->schedule === 'c10309') selected @endif value="c10309">
                                                {{$_lang->data->c10309}}
                                            </option>
                                            <option @if($tour->schedule === 'c43') selected @endif value="c43">
                                                {{$_lang->data->c43}}
                                            </option>
                                            <option @if($tour->schedule === 'c157') selected @endif value="c157">
                                                {{$_lang->data->c157}}
                                            </option>
                                            <option @if($tour->schedule === 'c65') selected @endif value="c65">
                                                {{$_lang->data->c65}}
                                            </option>
                                            <option @if($tour->schedule === 'c239') selected @endif value="c239">
                                                {{$_lang->data->c239}}
                                            </option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date" class="secondGreyColor">{{$_lang->data->data_to}}</label>
                                    <input class="form-control form-control-sm dateInp" type="date" id="date"
                                           name="date">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-group-xs">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkDateTo">
                                        <label class="custom-control-label secondGreyColor"
                                               for="checkDateTo">{{$_lang->data->data_from}}</label>
                                    </div>
                                    <input class="form-control form-control-sm dateInp" type="date" id="dateTo"
                                           name="dateTo" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-sm btn-block" id="send"
                                        type="button">{{$_lang->data->search}}</button>
                            </div>
                            {{--*************************************--}}

                            <div class="col-md-12 wrap-rasp hideme">

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="air-rasp-tab" data-toggle="tab" href="#air-rasp"
                                           role="tab" aria-controls="air-rasp" aria-selected="true">
                                            <i class="fa fa-plane" aria-hidden="true"></i> {{$_lang->data->plane}}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile"
                                           role="tab" aria-controls="profile" aria-selected="false">
                                            <i class="fa fa-train" aria-hidden="true"></i> {{$_lang->data->train}}
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="air-rasp" role="tabpanel"
                                         aria-labelledby="air-rasp-tab">
                                        <div class="col-12">
                                            <h3 class="title">{{$_lang->data->schedule}}</h3>
                                        </div>
                                        {{----}}
                                        <div class="col-md-12" id="outputScheduleplane" style="overflow-x: auto">
                                            <p>Пусто</p>
                                        </div>
                                        {{----}}
                                        <div class="col-12 wrap-obr wrap-rasp-plane" style="display: none">
                                            <div class="row">
                                                <h3>Обратно</h3>
                                                <div class="col-md-12" id="inputScheduleplane" style="overflow-x: auto">
                                                    <p>Пусто</p>
                                                </div>
                                            </div>
                                        </div>
                                        {{----}}
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel"
                                         aria-labelledby="profile-tab">
                                        <div class="col-12">
                                            <h3 class="title">{{$_lang->data->schedule}}</h3>
                                        </div>
                                        {{----}}
                                        <div class="col-md-12" id="outputScheduletrain" style="overflow-x: auto">
                                            <p>Пусто</p>
                                        </div>
                                        {{----}}
                                        <div class="col-12 wrap-obr wrap-rasp-train" style="display: none">
                                            <div class="row">
                                                <h3>Обратно</h3>
                                                <div class="col-md-12" id="inputScheduletrain" style="overflow-x: auto">
                                                    <p>Пусто</p>
                                                </div>
                                            </div>
                                        </div>
                                        {{----}}
                                    </div>
                                </div>
                            </div>
                            {{--***************************************--}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{$_lang->data->close}}</button>
                </div>
            </div>
        </div>
    </div>


    <script>
                @if(count($tour->route) === 1)
        var locations = {lat: {{$tour->route[0]->lat}}, lng: {{$tour->route[0]->lng}} };
                @else
        var locations = [
                        @if(count($tour->route))
                        @foreach($tour->route as $key=>$value)
                ['', {{$value->lat}}, {{$value->lng}}, {{$key++}}],
                    @endforeach
                    @endif
            ];
                @endif

        var langSchedule = {
                'load': '{{$_lang->data->load}}',
                'error': '{{$_lang->data->error}}',
                'empty': '{{$_lang->data->empty}}',
                'company': '{{$_lang->data->company}}',
                'room': '{{$_lang->data->room}}',
                'route': '{{$_lang->data->route}}',
                'departure': '{{$_lang->data->departure}}',
                'arrival': '{{$_lang->data->arrival}}',
            }
    </script>
@endsection