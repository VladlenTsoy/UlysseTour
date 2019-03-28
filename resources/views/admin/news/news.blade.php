@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Новости</div>
                    <div class="card-body">

                        <a class="btn btn-primary" href="/admin/news/create">Добавить</a>

                        <hr>

                        <table class="table">
                            <thead>
                            <th>Картинка</th>
                            <th>Название</th>
                            <th>Время</th>
                            <th>Язык</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach($news as $val)
                                <tr>
                                    <td><img src="{{$val->image}}" alt="" width="75px"></td>
                                    <td>{{$val->title}}</td>
                                    <td>{{ Carbon\Carbon::parse($val->created_at)->format('d-m-Y')}}</td>
                                    <td>{{$val->lang}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="/admin/news/{{$val->id}}" class="btn btn-secondary">Изменить</a>
                                            <a href="/admin/news/{{$val->id}}/delete" onclick="return confirm('Вы уверены, что хотите удалить?')" class="btn btn-danger">Удалить</a>
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

