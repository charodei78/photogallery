@extends('layouts.base')

@section('title', 'Upload image')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        Image upload
                    </div>
                    <div class="card-body">
                        <form action="{{route('upload.uploadFile')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(Session::has('success'))
                                <div class="alert alert-success">
                                    {{Session::get('success')}}
                                </div>
                            @endif
                            @if(Session::has('error'))
                                <div class="alert alert-danger">
                                    {{Session::get('error')}}
                                </div>
                            @endif
                            <input type="hidden" name="album_id" readonly id="album_id" value="{{$album_id}}">
                            <div class="form-group">
                                @error('name')
                                <div class="alert alert-danger">
                                    {{$message}}
                                </div>
                                @enderror
                                <label for="name">Title</label>
                                <input type="name" name="name" id="name">
                            </div>
                            <div class="form-group">
                                @error('file')
                                <div class="alert alert-danger">
                                    {{$message}}
                                </div>
                                @enderror
                                <input type="file" name="file" accept="image/x-png,image/jpeg, image/jpg" id="file">
                            </div>
                            <button class="btn btn-success">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
