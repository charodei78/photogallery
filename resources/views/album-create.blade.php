@extends('layouts.base')

@section('title', 'Create new album')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        Album creating
                    </div>
                    <div class="card-body">
                        <form action="{{route('albums.add')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                @error('name')
                                <div class="alert alert-danger">
                                    {{$message}}
                                </div>
                                @enderror
                                <label for="name">Put the name</label>
                                <input type="text" name="name" id="name">
                            </div>
                            <button class="btn btn-success">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
