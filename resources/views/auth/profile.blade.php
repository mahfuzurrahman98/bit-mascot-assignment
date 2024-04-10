@extends('layout')

@section('title', 'Profile')

@section('content')
    <div class="w-100 mx-auto mt-3" style="max-width:540px">
        <div class="d-flex justify-content-center mb-5">
            <div class="border border-2 border-dark text-center px-2 py-1" style="width: fit-content;">
                <h1 class="fs-3 my-0">User Profile</h1>
            </div>
        </div>
        @php
            $user = Auth::user();
        @endphp
        <div>
            <div class="row mb-3">
                <div class="col-sm-3">First name:</div>
                <div class="col-sm-9">
                    {{ $user->first_name }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">Last name:</div>
                <div class="col-sm-9">
                    {{ $user->last_name }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">Address:</div>
                <div class="col-sm-9">
                    {{ $user->address }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">Phone:</div>
                <div class="col-sm-9">
                    {{ $user->phone }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">Email:</div>
                <div class="col-sm-9">
                    {{ $user->email }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">Birth Date:</div>
                <div class="col-sm-9">
                    {{ \Carbon\Carbon::parse($user->dob)->format('F j, Y') }}
                </div>
            </div>
        </div>
    </div>
@endsection
