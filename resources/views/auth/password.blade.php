@extends('layout')

@section('title', 'Profile')

@section('content')
    <div class="w-100 mx-auto mt-3" style="max-width:540px">
        <div class="d-flex justify-content-center mb-5">
            <div class="border border-2 border-dark text-center px-2 py-1" style="width: fit-content;">
                <h1 class="fs-3 my-0">Change Password</h1>
            </div>
        </div>

        {{-- A form with 3 input fields and a submit button and a reset button --}}
        <form method="POST" action="{{ route('password.update') }}" class="pt-3">
            @csrf
            @method('PUT')
            <div class="mb-2 mb-md-3 row">
                <label for="old_password" class="col-sm-4 col-form-label">Old Password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="old_password" name="old_password" required />
                    @error('old_password')
                        <div class="text-danger fs-7">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-2 mb-md-3 row">
                <label for="password" class="col-sm-4 col-form-label">New Password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="password" name="password" required />
                    @error('password')
                        <div class="text-danger fs-7">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-4 row">
                <label for="password_confirmation" class="col-sm-4 col-form-label">Confirm Password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        required />
                </div>
            </div>
            <div class="d-flex justify-content-end gap-3">
                <button type="submit" class="btn btn-dark">Update</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>
    </div>
@endsection
