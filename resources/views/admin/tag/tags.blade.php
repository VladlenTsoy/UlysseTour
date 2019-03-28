@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Метатеги</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <th>Название</th>
                            <th>Время</th>
                            <th>Язык</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach($tags as $tag)
                                <tr>
                                    <td>{{$tag->title}}</td>
                                    <td>{{$tag->lang}}</td>
                                    <td>
                                        <a href="/admin/guide/{{$tag->id}}" class="btn btn-secondary">Изменить</a>
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

