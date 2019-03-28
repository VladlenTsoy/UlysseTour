@extends('layouts.app')

@section('content')

    <div class="block-content container">
        <div class="col-12">
            <div class="row">
                @foreach($guide as $item)
                    <div class="col-md-6 block-news-main">
                        <div class="row">
                            <div class="col-12">
                                <h2 class="title">{{$item->title}}</h2>
                                <p class="desc-content">{{$item->min_description}}</p>
                            </div>
                            <div class="col-12 text-right">
                                <a href="/{{$lang->title}}/guide/{{$item->id}}" class="btn btn-primary">{{$lang->data->read_more}}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection