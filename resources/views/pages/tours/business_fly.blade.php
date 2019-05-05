@extends('layouts.app')

@section('content')
    <div class="block-content container">
        <div class="col-12">
            <div class="row">

                <div class="col-md-4">
                    <h2>Чартеры</h2>
                    {!! $_lang->data->business_fly_text !!}
                </div>
                <div class="col-md-8">
                    <h2>Направления</h2>
                    <table class="table table-bordered table-responsive-md table-helicopter">
                        <thead class="thead-dark">
                        <th>{{$_lang->data->route}}</th>
                        <th>{{$_lang->data->cost}}</th>
                        <th>{{$_lang->data->number_of_tourists}}</th>
                        <th></th>
                        </thead>
                        <tbody>
                        @foreach($charters as $val)
                            <tr>
                                <td>{{$val->route}}</td>
                                <td>{{$val->cost}}</td>
                                <td>{{$val->max_qty_tourists}}</td>
                                <td>
                                    <a href="" data-toggle="modal"
                                       data-target="#modalBookIt" >{{$_lang->data->book_it}}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

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

                                {{--                                <input type="hidden" hidden value="{{$tour->id}}" name="id">--}}

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

@endsection
