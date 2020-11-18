@extends('layouts.base')

@section('title', 'Edit album')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        Album editor
                    </div>
                    <div class="card-body">
                        <form action="{{route('albums.edit')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$album['id']}}">
                            <div class="form-group">
                                @error('name')
                                <div class="alert alert-danger">
                                    {{$message}}
                                </div>
                                @enderror
                                <label for="name">Edit the name</label>
                                <input type="text" name="name" value="{{$album['name']}}" id="name">
                            </div>
                            <button class="btn btn-success">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
