@php
    $user = Auth::user();
@endphp

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile - Bit Mascot Assignment</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <div class="d-flex flex-column min-vh-100">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand px-1 fw-semibold" href="#">
                    {{ Auth::user()->role == 1 ? 'Admin' : 'User' }} Portal
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                {{ $user->first_name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if (Auth::user()->role == 2)
                                    <li class="d-block d-md-none">
                                        <a class="dropdown-item" href="#">Profile Page</a>
                                    </li>
                                    <li class="d-block d-md-none">
                                        <a class="dropdown-item" href="#">Change Password</a>
                                    </li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                    {{-- <a class="dropdown-item" href="#">Logout</a> --}}
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="d-flex">
            {{-- A sidebar --}}
            <div class="d-none d-md-block bg-body-tertiary min-vh-100 border border-r-2" style="width: 250px;">
                @if (Auth::user()->role == 1)
                    <a href="{{ route('users.index') }}"
                        class="d-block p-3 border-bottom border-2 border-dark text-decoration-none text-dark">
                        User List
                    </a>
                @else
                    <a href="{{ route('profile') }}"
                        class="d-block p-3 border-bottom border-2 border-dark text-decoration-none text-dark">
                        Profile Page
                    </a>
                    {{-- <a href="{{ route('password.change') }}"
                        class="d-block p-3 border-bottom border-2 border-dark text-decoration-none text-dark">
                        Password Change
                    </a> --}}
                @endif
            </div>

            <div class="w-100 mx-auto p-4 mt-3" style="max-width:480px">
                <div class="d-flex justify-content-center mb-5">
                    <div class="border border-2 border-dark text-center px-2 py-1" style="width: fit-content;">
                        <h1 class="fs-3 my-0">User Profile</h1>
                    </div>
                </div>
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
        </div>
    </div>
</body>

</html>
