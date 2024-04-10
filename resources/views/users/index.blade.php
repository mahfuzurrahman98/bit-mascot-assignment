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
    <table class="table table-striped table-hover mt-3">
        <thead class="table-secondary">
            <tr>
                <th class="fw-semibold">Name</th>
                <th class="fw-semibold">Address</th>
                <th class="fw-semibold">Phone</th>
                <th class="fw-semibold">Email</th>
                <th class="fw-semibold">Date of Birth</th>
                <th class="fw-semibold">ID Verification</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->address }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ date('d/m/Y', strtotime($user->dob)) }}</td>
                    <td class="text-center">
                        <a href="{{ $user->id_verification_file_url }}" target="_blank">
                            <img src="{{ asset('assets/icons/file-pdf.svg') }}" alt="PDF Icon" width="24">
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@endsection
