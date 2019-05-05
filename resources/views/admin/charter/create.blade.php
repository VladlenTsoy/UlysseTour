@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Добавить чартер</div>
                    <div class="card-body">

                        <form class="was-validated" method="POST" action="/admin/charter/create"
                              enctype="multipart/form-data">
                            {!! csrf_field() !!}

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cost">Стоимость</label>
                                        <input type="text" class="form-control" id="cost" name="cost" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="lang">Язык</label>
                                        <select class="form-control" name="lang" id="lang" required>
                                            @foreach($lang as $item)
                                                <option value="{{$item->title}}">{{$item->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="route">Машрут</label>
                                        <input type="text" class="form-control" id="route" name="route" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="max_qty_tourists">Кол-во мест</label>
                                        <input type="number" class="form-control" id="max_qty_tourists"
                                               name="max_qty_tourists" required>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection