@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @foreach ($hospitals as $hospital)
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$hospital->name}}</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="{{route('hospital.login',['hospital'=> $hospital->username ])}}"
                        class="btn btn-primary">Login</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection