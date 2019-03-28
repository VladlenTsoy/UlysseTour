@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Изменить новость</div>
                    <div class="card-body">

                        <form class="was-validated" method="POST" action="/admin/news/{{$news->id}}"
                              enctype="multipart/form-data">
                            {!! csrf_field() !!}

                            <div class="form-group">
                                <label for="title">Название</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       placeholder="Введите название" required value="{{$news->title}}">
                            </div>

                            @if($news->image)
                                <div class="form-group">
                                    <label for="image-select" class="image-selection success">
                                        <span class="title-image-selection" id="title-image">Выберите картинку</span>
                                        <input type="file" hidden="hidden" id="image-select" name="image">
                                        <img src="{{$news->image}}" class="out-image" id="out-image">
                                    </label>
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="image-select" class="image-selection">
                                        <span class="title-image-selection" id="title-image">Выберите картинку</span>
                                        <input type="file" hidden="hidden" id="image-select" name="image" required>
                                        <img src="" class="hideme out-image" id="out-image">
                                    </label>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="description">Описание</label>
                                <textarea class="form-control" id="news-description"
                                          name="description">{{$news->description}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="lang">Язык</label>
                                <select class="form-control" name="lang" id="lang" required>
                                    @foreach($lang as $item)
                                        <option value="{{$item->title}}"
                                                @if($item->title === $news->lang) selected @endif
                                        >{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Изменить</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
