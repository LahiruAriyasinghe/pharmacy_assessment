@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="page-title-btn">
        <div class="page-title-with-button"><span><img class="page-title-icon" src="{{ asset('img/result.svg') }}">
            </span>Manage Lab Reports
        </div>
    </div>
    <hr>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="row mb-3">
                @can('create lab report', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular  m-2 shadow-sm w-100" href="{{route('lab-reports.index')}}"
                        role="button">
                        <img class="tile-icon" src="{{ asset('img/result.svg') }}">
                        <div class="tile-title">All Lab Reports</div>
                    </a>
                </div>
                @endcan

                @can('create test data category', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 w-100" href="{{route('lab-reports.categories.index')}}"
                        role="button">
                        <img class="tile-icon" src="{{ asset('img/reoprt-category.svg') }}">
                        <div class="tile-title">Report Categories</div>
                    </a>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>
<div class="container mt-4">
    <div class="page-title-btn">
        <div class="page-title-with-button"><span><img class="page-title-icon" src="{{ asset('img/test-data.svg') }}">
            </span>Manage Test Data
        </div>
    </div>
    <hr>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="row mb-3">
                @can('create unit', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 w-100" href="{{route('units.index')}}" role="button">
                        <img class="tile-icon" src="{{ asset('img/test-tube.svg') }}">
                        <div class="tile-title">Measuring Units</div>
                    </a>
                </div>
                @endcan

                @can('create result category', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 w-100" href="{{route('test-data.result-categories.index')}}"
                        role="button">
                        <img class="tile-icon" src="{{ asset('img/result-category.svg') }}">
                        <div class="tile-title">Result Categories</div>
                    </a>
                </div>
                @endcan

                @can('create test data category', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 w-100" href="{{route('test-data.categories.index')}}" role="button">
                        <img class="tile-icon" src="{{ asset('img/lab-test-category.svg') }}">
                        <div class="tile-title">Lab Test Data Categories</div>
                    </a>
                </div>
                @endcan

                @can('create test data', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 w-100" href="{{route('test-datas.index')}}" role="button">
                        <img class="tile-icon" src="{{ asset('img/lab-data.svg') }}">
                        <div class="tile-title">Lab Test Data</div>
                    </a>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>

@endsection