@extends('layout')

@section('title', 'Profile')

@section('content')
    <div class="d-flex justify-content-between border-bottom border-2 pb-2">
        <h1 class="fs-4">User List</h1>
        <form role="search" action="{{ route('users.index') }}">
            <input type="text" name="search" id="search" class="form-control form-control-sm"
                value="{{ request()->query('search') }}" placeholder="Search">
        </form>
    </div>
    <table class="table mt-3">
        <thead class="table-light">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Phone</th>
                <th scope="col">Email</th>
                <th scope="col">Date of Birth</th>
                <th scope="col">ID Verification</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->address }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->dob }}</td>
                    <td>{{ $user->id_verification_file }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@endsection
