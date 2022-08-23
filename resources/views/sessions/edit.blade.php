@extends('layouts.app')

@section('title', 'Edit Services')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Session</div>

                <div class="card-body">
                    <form action="{{route('sessions.update', $session)}}" method="post" id="session_form">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Session Name</label>
                            <div class="col-md-6">
                                <input id="session_name" type="text" class="form-control" name="name" value="{{$session->name}}">
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Room No</label>
                            <div class="col-md-6">
                                <input id="room_no" type="text" class="form-control" name="room_no" value="{{$session->room_no}}">
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Doctor In Charge</label>
                            <div class="col-md-6">
                                <select class="form-control" id="doctor_id" name="doctor_id">
                                    @foreach($doctors as $doctor)
                                    <option value="{{$doctor->doctor->id}}" @if($doctor->doctor->id == $session->doctor_id) selected @endif>{{$doctor->first_name}} {{$doctor->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Nurse In Charge (Optional)</label>
                            <div class="col-md-6">
                                <select class="form-control" id="nurse_id" name="nurse_id">
                                    <option value="">None</option>
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}" @if($user->id == $session->nurse_id) selected @endif>{{$user->first_name}} {{$user->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Day of Week</label>
                            <div class="col-md-3">
                                <select class="form-control" id="week_day" name="week_day">
                                     <option value="Monday" @if ($session->week_day == 'Monday') selected @endif>Monday</option>
                                    <option value="Tuesday" @if ($session->week_day == 'Tuesday') selected @endif>Tuesday</option>
                                    <option value="Wednesday" @if ($session->week_day == 'Wednesday') selected @endif>Wednesday</option>
                                    <option value="Thursday" @if ($session->week_day == 'Thursday') selected @endif>Thursday</option>
                                    <option value="Friday" @if ($session->week_day == 'Friday') selected @endif>Friday</option>
                                    <option value="Saturday" @if ($session->week_day == 'Saturday') selected @endif>Saturday</option>
                                    <option value="Sunday" @if ($session->week_day == 'Sunday') selected @endif>Sunday</option>
                                </select>
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Start At</label>
                            <div class="col-md-3">
                                <input id="start_at" type="time" class="form-control" name="start_at" value="{{$session->start_at}}">
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">End At</label>
                            <div class="col-md-3">
                                <input id="end_at" type="time" class="form-control" name="end_at" value="{{$session->end_at}}">
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Max no of patients</label>
                            <div class="col-md-6">
                                <input id="maximum_patients" type="text" class="form-control" name="maximum_patients" value="{{$session->maximum_patients}}">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-secondary" onclick="window.history.back()">Close</button>
                                <button type="submit" class="btn btn-primary" id="session_save_btn">
                                    Update Session
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{asset('js/sessions/edit.js')}}"></script>
@endpush