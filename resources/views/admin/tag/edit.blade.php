@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Метатег</div>
                    <div class="card-body">

                        <form class="was-validated" method="POST" action="/admin/tag/{{$tag->id}}">
                            {!! csrf_field() !!}

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meta_title">Название (Метатег)</label>
                                        <input type="text" class="form-control" id="meta_title" name="title"
                                               placeholder="Введите название" value="{{$tag->title}}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="url">Ссылка (Url)</label>
                                        <input type="text" class="form-control" id="url" name="user_url"
                                               placeholder="Введите название" value="{{$tag->user_url}}">
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meta_desc">Описание (Метатег)</label>
                                        <textarea class="form-control" id="meta_desc" name="description" required
                                                  rows="5">{{$tag->description}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

