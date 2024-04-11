@php
    $user = Auth::user();
@endphp

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @yield('title') - Bit Mascot Assignment
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="d-flex flex-column min-vh-100">
        <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom border-2 border-dark">
            <div class="container-fluid">
                <a class="navbar-brand px-1 fw-semibold" href="#">
                    {{ Auth::user()->role == 1 ? 'Admin' : 'User' }} Portal
                </a>

                <button class="navbar-toggler px-1 py-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown px-1">
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
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="d-flex">
            <div class="d-none d-md-block bg-body-tertiary min-vh-100 border-end border-2 border-dark"
                style="width: 250px;">
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
                    <a href="{{ route('password.form') }}"
                        class="d-block p-3 border-bottom border-2 border-dark text-decoration-none text-dark">
                        Password Change
                    </a>
                @endif
            </div>

            <div class="w-100 p-3">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>
