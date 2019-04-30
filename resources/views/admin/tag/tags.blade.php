@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Метатеги</div>
                    <div class="card-body">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Добавить тур
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <span class="dropdown-item-text">Выберите язык</span>
                                @foreach($langs as $lang)
                                    <a class="dropdown-item"
                                       href="/admin/tag/create/{{$lang->title}}">{{$lang->title}}</a>
                                @endforeach
                            </div>
                        </div>
                        <hr>
                        <table class="table">
                            <thead>
                            <th>Название</th>
                            <th>Дополнение</th>
                            <th>Язык</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach($tags as $tag)
                                <tr>
                                    <td>{{$tag->title}}</td>
                                    <td>{{$tag->user_url ?? 'Нет'}}</td>
                                    <td>{{$tag->lang}}</td>
                                    <td>
                                        <a href="/admin/tag/{{$tag->id}}" class="btn btn-secondary">Изменить</a>
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

