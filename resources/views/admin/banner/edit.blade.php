@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Изменить баннер</div>
                    <div class="card-body">

                        <form class="was-validated" method="POST" action="/admin/banner/{{$banner->id}}"
                              enctype="multipart/form-data">
                            {!! csrf_field() !!}

                            <div class="form-group">
                                <label for="title">Текст сверху</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       placeholder="Введите текст" required value="{{$banner->title}}">
                            </div>

                            <div class="form-group">
                                <label for="sub_title">Текст снизу</label>
                                <input type="text" class="form-control" id="sub_title" name="sub_title"
                                       placeholder="Введите текст" required value="{{$banner->sub_title}}">
                            </div>

                           <div class="form-group">
                                <label for="name_link">Название ссылки</label>
                                <input type="text" class="form-control" id="name_link" name="name_link"
                                       placeholder="Введите название ссылки" value="{{$banner->name_link}}">
                            </div>


                           <div class="form-group">
                                <label for="link">Ссылка</label>
                                <input type="text" class="form-control" id="link" name="link"
                                       placeholder="Введите ссылку" value="{{$banner->link}}">
                            </div>

                            @if($banner->image)
                                <div class="form-group">
                                    <label for="image-select" class="image-selection success">
                                        <span class="title-image-selection" id="title-image">Выберите картинку</span>
                                        <input type="file" hidden="hidden" id="image-select" name="image">
                                        <img src="{{$banner->image}}" class="out-image" id="out-image">
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
                                <label for="lang">Язык</label>
                                <select class="form-control" name="lang" id="lang" required>
                                    @foreach($lang as $item)
                                        <option value="{{$item->title}}"
                                                @if($item->title === $banner->lang) selected @endif
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

