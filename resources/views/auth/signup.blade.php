<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <div class="d-flex flex-colum min-vh-100">
        <div class="w-100 mt-2 flex flex-colum mx-auto p-3" style="max-width: 1280px">
            <div class="text-center">
                <img src="{{ asset('assets') }}/icons/circle-user.svg" width="60" alt="">
                <h1 class="fs-3 mt-3">Register Your Account</h1>
            </div>
            <div class="w-100 mx-auto p-4 border border-2 border-dark mt-3" style="max-width:640px">
                <form class="row g-3">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="first_name"
                            placeholder="Enter your first name" required />
                    </div>

                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="last_name"
                            placeholder="Enter your last name" required />
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" id="address"
                            placeholder="Enter your address" required />
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone"
                            placeholder="Enter your phone number" required />
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email"
                            placeholder="Enter your email" required />
                    </div>

                    <div class="col-md-12">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" name="dob" id="dob"
                            placeholder="Enter your date of birth" required />
                    </div>

                    <div class="col-md-12">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="Enter your password" required />
                    </div>

                    <div class="col-md-12">
                        <label for="password_confirm" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirm" id="password_confirm"
                            placeholder="Enter your password again" required />
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-dark px-4">Sign Up</button>
                    </div>

                    <div class="">
                        Already have an account? <span><a href="{{ route('login') }}">Login</a></span>
                    </div>

                </form>
            </div>
        </div>
    </div>




    <script type="module">
        $(document).ready(function() {
            $('#testButton').click(function() {
                alert('safdsafs');
            });
        });
    </script>
</body>

</html>
