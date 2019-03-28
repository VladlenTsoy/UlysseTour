@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$title}}</div>
                    <div class="card-body">

                        <a class="btn btn-primary" href="/admin/{{$table}}/create">Добавить</a>

                        <hr>

                        <table class="table">
                            <thead>
                            <th>Название</th>
                            <th>Язык</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach($rows as $row)
                                <tr>
                                    <td>{{$row->title}}</td>
                                    <td>{{$row->lang}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="/admin/{{$table}}/{{$row->id}}" class="btn btn-secondary">Изменить</a>
                                            <a href="/admin/{{$table}}/{{$row->id}}/delete" onclick="return confirm('Вы уверены, что хотите удалить?')" class="btn btn-danger">Удалить</a>
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

