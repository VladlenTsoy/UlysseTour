@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$title}}</div>
                    <div class="card-body">

                        <form class="was-validated" method="POST" action="/admin/include/{{$table}}/{{$service->id}}"
                              enctype="multipart/form-data">
                            {!! csrf_field() !!}

                            <div class="form-group">
                                <label for="title">Название</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       placeholder="Введите название" required value="{{$service->title}}">
                            </div>

                            <div class="form-group">
                                <label for="description">Описание</label>
                                <textarea class="form-control" id="news-description"
                                          name="description">{{$service->description}}</textarea>
                            </div>


                            <div class="form-group">
                                <label for="lang">Язык</label>
                                <select class="form-control" name="lang" id="lang" required>
                                    @foreach($lang as $item)
                                        <option value="{{$item->title}}"
                                                @if($item->title === $service->lang) selected @endif
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

