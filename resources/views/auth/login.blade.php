<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bit Mascot Assignment</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <div class="d-flex flex-colum min-vh-100">
        <div class="w-100 mt-2 flex flex-colum mx-auto p-3" style="max-width: 1280px">
            <div class="text-center">
                <img src="{{ asset('assets') }}/icons/circle-user.svg" width="60" alt="">
                <h1 class="fs-3 mt-3">Login</h1>
            </div>
            <div class="w-100 mx-auto p-4 border border-2 border-dark mt-3" style="max-width:480px">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form class="row g-3" method="POST" action="{{ route('authenticate') }}">
                    @csrf

                    <div class="col-md-12">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" id="email"
                            value="{{ old('email') }}" placeholder="Enter your email" required />
                        @error('email')
                            <div class="text-danger fs-7">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="Enter your password" required />
                        @error('password')
                            <div class="text-danger fs-7">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-dark px-4">Login</button>
                    </div>

                    <div class="">
                        Don't have an account? <span><a href="{{ route('signup') }}">Sign Up</a></span>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

</html>
