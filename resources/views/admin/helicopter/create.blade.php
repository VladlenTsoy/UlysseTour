@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Добавить вертолетный</div>
                    <div class="card-body">

                        <form class="was-validated" method="POST" action="/admin/helicopter/create"
                              enctype="multipart/form-data">
                            {!! csrf_field() !!}

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="tour_id">Выберите тур</label>
                                        <select class="form-control js-example-basic-single" name="tour_id" id="tour_id" required>
                                            @foreach($tours as $tour)
                                            <option value="{{$tour->id}}">#{{$tour->id}} {{$tour->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{--                                    <div class="form-group">--}}
                                    {{--                                        <label for="category">Категория</label>--}}
                                    {{--                                        <select class="form-control" name="category" id="category" required>--}}
                                    {{--                                            <option value="0">Heliski</option>--}}
                                    {{--                                            <option value="1">Business fly</option>--}}
                                    {{--                                        </select>--}}
                                    {{--                                    </div>--}}
                                    <div class="form-group">
                                        <label for="date">Дата</label>
                                        <input type="date" class="form-control" id="date" name="date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cost">Стоимость</label>
                                        <input type="text" class="form-control" id="cost" name="cost" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Название</label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="place">Место</label>
                                        <input type="text" class="form-control" id="place" name="place" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="max_qty_tourists">Кол-во мест</label>
                                        <input type="number" class="form-control" id="max_qty_tourists"
                                               name="max_qty_tourists" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="lang">Язык</label>
                                <select class="form-control" name="lang" id="lang" required>
                                    @foreach($lang as $item)
                                        <option value="{{$item->title}}">{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection