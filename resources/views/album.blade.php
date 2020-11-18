@extends('layouts.base')
@if(!$photos->isEmpty())
    @section('title', 'Album: '.$photos[0]->album)
@else
    @section('title', 'Empty album')
@endif

@section('content')

    <div class="container justify-content-around d-inline-flex" style="margin-top: 50px;">
        @foreach($photos as $photo)
            <div class="card" style="width: 250px;">
                <img
                    src="{{asset($photo->path_resize)}}"
                    class="card-img-top"
                    alt="..."
                    style="max-height: 150px; object-fit: cover"
                >
                <div class="card-body">
                    <h5 class="card-title">{{$photo->name}}</h5>
                    <div class="btn-group" role="group" aria-label="Basic example">
                      <a type="button" href="{{asset($photo->path)}}" target="_blank" class="btn btn-primary">Look</a>
                      <a type="button"  href="{{route('image.delete', ['id' => $photo->id])}}" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>

        @endforeach
    </div>

    <a
        href="{{route('upload.index', ['album_id' => $album_id])}}"
        style="margin: 30px"
        class="btn fixed-bottom shadow-sm btn-primary btn-lg"
    >+ Add photo
    </a>
@endsection


@section('content')
    <h1>Album is empty</h1>
@endsection


