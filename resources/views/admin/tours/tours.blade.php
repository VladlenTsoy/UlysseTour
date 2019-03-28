@extends('layouts.admin')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title-block">
                    <h4 class="card-title">Туры</h4>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Добавить тур
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <span class="dropdown-item-text">Выберите язык</span>
                            @foreach($langs as $lang)
                                <a class="dropdown-item"
                                   href="/admin/tour/create/{{$lang->title}}">{{$lang->title}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <hr>

                <table class="table table-hover">
                    <thead class="text-secondary">
                    <th>#</th>
                    <th>Местность</th>
                    <th>Название</th>
                    <th>Продолжит.</th>
                    <th>Сезон</th>
                    <th>Категория</th>
                    <th>Кол-во чел.</th>
                    <th>Цена</th>
                    <th>🔥</th>
                    <th>Язык</th>
                    <th></th>
                    </thead>
                    <tbody class="table-sm">
                    @foreach($tours as $tour)
                        <tr class="text-muted">
                            <td>{{$tour->id}}</td>
                            <td>{{$lang->data->country[(int) $tour->country]}}</td>
                            <td>{{$tour->title}}</td>
                            <td>{{$tour->duration}}</td>
                            <td>{{$tour->season_title}}</td>
                            <td>{{$tour->category_title}}</td>
                            <td>{{$tour->max_qty_tourists}}</td>
                            <td>{{$tour->cost}}</td>
                            <td>{{$tour->hot ? date('d/m/y', strtotime($tour->hot)) : ''}}</td>
                            <td>{{$tour->lang}}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/admin/tour/{{$tour->id}}/{{$tour->lang}}"
                                       class="btn btn-sm btn-secondary"><i class="fa fa-pencil"></i></a>
                                    <a href="/admin/tour/{{$tour->id}}/delete/{{$tour->lang}}"
                                       onclick="return confirm('Вы уверены, что хотите удалить?')"
                                       class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

