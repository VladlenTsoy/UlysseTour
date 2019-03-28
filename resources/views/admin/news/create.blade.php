@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Добавить новость</div>
                    <div class="card-body">

                        <form class="was-validated" method="POST" action="/admin/news" enctype="multipart/form-data">
                            {!! csrf_field() !!}

                            <div class="form-group">
                                <label for="title">Название</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       placeholder="Введите название" required>
                            </div>

                            <div class="form-group">
                                <label for="image-select" class="image-selection">
                                    <span class="title-image-selection" id="title-image">Выберите картинку</span>
                                    <input type="file" hidden="hidden" id="image-select" name="image" required>
                                    <img src="" class="hideme out-image" id="out-image">
                                </label>
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

