@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Путеводитель</div>
                    <div class="card-body">

                        <form class="was-validated" method="POST" action="/admin/guide">
                            {!! csrf_field() !!}

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meta_title">Название (Метатег)</label>
                                        <input type="text" class="form-control" id="meta_title" name="meta_title"
                                               placeholder="Введите название" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="url">Ссылка (Url)</label>
                                        <input type="text" class="form-control" id="url" name="url"
                                               placeholder="Введите название" required>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meta_desc">Описание (Метатег)</label>
                                        <textarea class="form-control" id="meta_desc" name="meta_description" required
                                                  rows="5"></textarea>
                                    </div>

                                </div>

                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title">Название</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       placeholder="Введите название" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Описание</label>
                                <textarea class="form-control" id="news-description" name="description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="lang">Язык</label>
                                <select class="form-control" name="lang" id="lang" required>
                                    @foreach($lang as $item)
                                        <option value="{{$item->title}}">{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

