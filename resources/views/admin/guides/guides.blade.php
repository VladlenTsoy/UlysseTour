@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Путеводитель</div>
                    <div class="card-body">

                        <a class="btn btn-primary" href="/admin/guide/create">Добавить</a>

                        <hr>

                        <table class="table">
                            <thead>
                            <th>Название</th>
                            <th>Время</th>
                            <th>Язык</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach($guides as $guide)
                                <tr>
                                    <td>{{$guide->title}}</td>
                                    <td>{{ Carbon\Carbon::parse($guide->created_at)->format('d-m-Y')}}</td>
                                    <td>{{$guide->lang}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="/admin/guide/{{$guide->id}}" class="btn btn-secondary">Изменить</a>
                                            <a href="/admin/guide/{{$guide->id}}/delete" onclick="return confirm('Вы уверены, что хотите удалить?')" class="btn btn-danger">Удалить</a>
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

