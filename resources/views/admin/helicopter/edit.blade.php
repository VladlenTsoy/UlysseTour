@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Изменить вертолетный</div>
                    <div class="card-body">

                        <form class="was-validated" method="POST" action="/admin/helicopter/{{$helicopter->id}}/edit"
                              enctype="multipart/form-data">
                            {!! csrf_field() !!}

                            <div class="row">
                                <div class="col-md-6">
{{--                                    <div class="form-group">--}}
{{--                                        <label for="category">Категория</label>--}}
{{--                                        <select class="form-control" name="category" id="category" required>--}}
{{--                                            <option value="0" @if(0 === $helicopter->category) selected @endif>Heliski</option>--}}
{{--                                            <option value="1" @if(1 === $helicopter->category) selected @endif>Business fly</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
                                    <div class="form-group">
                                        <label for="date">Дата</label>
                                        <input type="date" class="form-control" id="date" name="date" value="{{$helicopter->date}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cost">Стоимость</label>
                                        <input type="text" class="form-control" id="cost" name="cost" value="{{$helicopter->cost}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Название</label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{$helicopter->title}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="place">Место</label>
                                        <input type="text" class="form-control" id="place" name="place" value="{{$helicopter->place}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="max_qty_tourists">Кол-во мест</label>
                                        <input type="number" class="form-control" id="max_qty_tourists" value="{{$helicopter->max_qty_tourists}}" name="max_qty_tourists" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="lang">Язык</label>
                                <select class="form-control" name="lang" id="lang" required>
                                    @foreach($lang as $item)
                                        <option value="{{$item->title}}"
                                                @if($item->title === $helicopter->lang) selected @endif>{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Изменить</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection