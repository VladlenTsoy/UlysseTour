@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Вертолетные</div>
                    <div class="card-body">

                        <a class="btn btn-primary" href="/admin/helicopter/create">Добавить</a>

                        <hr>

                        <table class="table">
                            <thead>
                            <th>Дата</th>
                            <th>Название</th>
                            <th>Стоимость</th>
                            <th>Кол-во</th>
                            <th>Место</th>
                            <th>Язык</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach($helicopters as $val)
                                <tr>
                                    <td>{{ Carbon\Carbon::parse($val->date)->format('d-m-Y')}}</td>
                                    <td>{{$val->title}}</td>
                                    <td>{{$val->cost}}</td>
                                    <td>{{$val->max_qty_tourists}}</td>
                                    <td>{{$val->place}}</td>
                                    <td>{{$val->lang}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="/admin/helicopter/{{$val->id}}" class="btn btn-secondary">Изменить</a>
                                            <a href="/admin/helicopter/{{$val->id}}/delete" onclick="return confirm('Вы уверены, что хотите удалить?')" class="btn btn-danger">Удалить</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
