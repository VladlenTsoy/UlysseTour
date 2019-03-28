@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Языки</div>
                    <div class="card-body">

                        <a class="btn btn-primary" href="/admin/language/create">Добавить</a>

                        <hr>

                        <table class="table">
                            <thead>
                            <th>Название</th>
                            <th>Время</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach($languages as $language)
                                <tr>
                                    <td>{{$language->title}}</td>
                                    <td>{{ Carbon\Carbon::parse($language->created_at)->format('d-m-Y')}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="/admin/language/{{$language->id}}" class="btn btn-secondary">Изменить</a>
                                            <a href="/admin/language/{{$language->id}}/delete" onclick="return confirm('Вы уверены, что хотите удалить?')" class="btn btn-danger">Удалить</a>
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

