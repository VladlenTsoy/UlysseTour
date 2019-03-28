@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$title}}</div>
                    <div class="card-body">

                        <a class="btn btn-primary" href="/admin/include/{{$table}}/create">Добавить</a>

                        <hr>

                        <table class="table">
                            <thead>
                            <th>Название</th>
                            <th>Язык</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach($services as $val)
                                <tr>
                                    <td>{{$val->title}}</td>
                                    <td>{{$val->lang}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="/admin/include/{{$table}}/{{$val->id}}" class="btn btn-secondary">Изменить</a>
                                            <a href="/admin/include/{{$table}}/{{$val->id}}/delete" onclick="return confirm('Вы уверены, что хотите удалить?')" class="btn btn-danger">Удалить</a>
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

