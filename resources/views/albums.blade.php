@extends('layouts.base')

@section('title', 'Albums')

@section('content')

    <div class="container justify-content-around d-inline-flex p-3" style="min-width: 90vw;margin-top: 50px;">
        @foreach($albums as $album)
            <div class="card shadow-sm" style="width: 15em;">
                <div class="card-body">
                    <h5 class="card-title">{{$album['name']}}</h5>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a type="button" href="{{route('albums.view', ['id' => $album->id])}}" class="btn btn-primary">Look</a>
                        <a type="button" href="{{route('albums.editor', ['id' => $album->id])}}" class="btn btn-success">Edit</a>
                        <a type="button" href="{{route('albums.delete', ['id' => $album->id])}}" class="btn btn-danger">Delete</a>
                    </div>
            </div>
    </div>
    @endforeach
    </div>

    <a
        href="{{route('albums.create')}}"
        style="margin: 30px"
        class="btn fixed-bottom shadow-sm btn-primary btn-lg"
    >+ Create new album
    </a>
@endsection
