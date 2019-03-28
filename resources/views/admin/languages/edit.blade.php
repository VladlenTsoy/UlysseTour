@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Язык</div>
                    <div class="card-body">

                        <form class="was-validated" method="POST" action="/admin/language/{{$id}}">
                            {!! csrf_field() !!}

                            <div class="row">
                                @foreach($languages->data as $key => $item)
                                    @if($key !== 'aboutus' && $key !== 'pluses')
                                        @if(gettype($item) === 'string')
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="key_{{$key}}">{{$item}}</label>
                                                    <input type="text" class="form-control" id="key_{{$key}}"
                                                           name="{{$key}}" required value="{{$item}}">
                                                </div>
                                            </div>
                                        @endif

                                        @if(gettype($item) === 'array')
                                            @foreach($item as $key_v => $val)
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="key_{{$key}}_{{$key_v}}">{{$val}}</label>
                                                        <input type="text" class="form-control"
                                                               id="key_{{$key}}_{{$key_v}}"
                                                               name="{{$key}}[]" required value="{{$val}}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    @elseif($key === 'aboutus')
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="news-description">Описание</label>
                                                <textarea class="form-control" id="news-description"
                                                          name="{{$key}}">{{$item}}</textarea>
                                            </div>
                                        </div>
                                    @elseif($key === 'pluses')
                                        @foreach($item as $key_pluses => $val)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="plus_title_{{$key_pluses}}">Название плюса
                                                        #{{$key_pluses+1}}</label>
                                                    <input type="text" class="form-control"
                                                           id="plus_title_{{$key_pluses}}"
                                                           name="pluses_title[]" required value="{{$val->title}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="plus_desc_{{$key_pluses}}">Название плюса
                                                        #{{$key_pluses+1}}</label>
                                                    <textarea type="text" class="form-control"
                                                              id="plus_desc_{{$key_pluses}}"
                                                              name="pluses_description[]"
                                                              required>{{$val->description}}</textarea>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                @endforeach
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="lang">Язык</label>
                                        <input type="text" class="form-control" id="lang"
                                               name="lang" required value="{{$languages->title}}">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Изменить</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

