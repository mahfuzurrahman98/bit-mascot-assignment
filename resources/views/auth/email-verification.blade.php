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
                <h1 class="fs-3 mt-3">
                    Verification Code
                </h1>
                <div>
                    A unique code has been sent to your email.
                </div>
            </div>
            <div class="w-100 mx-auto mt-4" style="max-width:480px">
                <div class="p-4 border border-2 border-dark">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <form class="row g-3" method="POST" action="{{ route('email.verify') }}">
                        @csrf

                        <div class="col-md-12">
                            <label for="otp" class="form-label">Verification Code</label>
                            <input type="text" class="form-control" name="otp" id="otp" required />
                            @error('otp')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-dark px-4">Verify</button>
                        </div>
                    </form>
                </div>
                <div class="mt-3 ps-4">
                    Don't have an account? <span><a href="{{ route('signup') }}">Sign Up</a></span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
