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
                                @foreach($def_language->data as $key => $item)
                                    @if($key !== 'aboutus' && $key !== 'pluses' && $key !== 'heliski_description' && $key !== 'business_fly_text' && $key !== 'heliski_text'&& $key !== 'helinature_text')
                                        @if(gettype($item) === 'string')
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="key_{{$key}}">{{$item}}</label>
                                                    <input type="text" class="form-control" id="key_{{$key}}"
                                                           name="{{$key}}" required
                                                           value="{{ property_exists($languages->data, $key) ? $languages->data->{$key}:'' }}">
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

                                    @elseif($key === 'helinature_text')
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="helinature_text">Вертолетные туры</label>
                                                <textarea class="form-control" id="helinature_text"
                                                          name="{{$key}}">{{$item}}</textarea>
                                            </div>
                                        </div>

                                    @elseif($key === 'business_fly_text')
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="business_fly_text">Чартеры</label>
                                                <textarea class="form-control" id="business_fly_text"
                                                          name="{{$key}}">{{$item}}</textarea>
                                            </div>
                                        </div>

                                    @elseif($key === 'heliski_text')
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="heliski_text">Хелиски Описание (Слева)</label>
                                                <textarea class="form-control" id="heliski_text"
                                                          name="{{$key}}">{{$item}}</textarea>
                                            </div>
                                        </div>

                                    @elseif($key === 'heliski_description')
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="heliski_description">Хелиски Иформация</label>
                                                <textarea class="form-control" id="heliski_description"
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

