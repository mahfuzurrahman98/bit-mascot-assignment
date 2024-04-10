<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bit Mascot Assignment</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .custom-file-input {
            position: relative;
            overflow: hidden;
        }

        .custom-file-input input {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }

        .file-upload {
            display: flex;
            flex-direction: column;
            padding: 5px;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            background-color: #e9ecef;
            border: 2px solid #343a40;
            border-radius: 5px;
            cursor: pointer;
        }

        .upload-icon {
            height: 30px;
            width: auto;
        }

        .upload-icon img {
            height: 100%;
            width: auto;
        }

        .upload-text {
            font-size: 16px;
        }

        /* Style the file input button when it's hovered */
        .custom-file-input input:hover+.file-upload {
            background-color: #adb5bd;
        }
    </style>
</head>

<body>
    <div class="d-flex flex-colum min-vh-100">
        <div class="w-100 mt-2 flex flex-colum mx-auto p-3" style="max-width: 1280px">
            <div class="text-center">
                <img src="{{ asset('assets') }}/icons/circle-user.svg" width="60" alt="">
                <h1 class="fs-3 mt-3">Register Your Account</h1>
            </div>
            <div class="w-100 mx-auto p-4 border border-2 border-dark mt-3" style="max-width:640px">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form class="row g-3" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-6">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="first_name"
                            placeholder="Enter your first name" value="{{ old('first_name') }}" required />
                        @error('first_name')
                            <div class="text-danger fs-7">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="last_name"
                            placeholder="Enter your last name" value="{{ old('last_name') }}" required />
                        @error('last_name')
                            <div class="text-danger fs-7">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" id="address"
                            placeholder="Enter your address" value="{{ old('address') }}" required />
                        @error('address')
                            <div class="text-danger fs-7">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone"
                            placeholder="Enter your phone number" value="{{ old('phone') }}"
                            oninput="sanitizePhone(this)" required />
                        @error('phone')
                            <div class="text-danger fs-7">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email"
                            placeholder="Enter your email" value="{{ old('email') }}" oninput="checkUserExists()"
                            required />
                        @error('email')
                            <div class="text-danger fs-7">{{ $message }}</div>
                        @enderror
                        <div class="text-success fs-7" id="email-exists-success"></div>
                        <div class="text-danger fs-7" id="email-exists-error"></div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 px-2">
                        <div class="col-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                        </div>
                        <div class="col-9">
                            <input type="date" class="form-control w-100" name="dob" id="dob"
                                placeholder="Enter your date of birth" value="{{ old('dob') }}" required />
                            @error('dob')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <label for="id_verification_file" class="form-label">ID Verification</label>
                        <div class="custom-file-input">
                            <input type="file" class="form-control" accept=".pdf" id="id_verification_file"
                                name="id_verification_file" required onchange="updateFileName()" />
                            <div for="id_verification_file" class="file-upload">
                                <div class="upload-text">
                                    Upload NID/Office ID for verification
                                </div>
                                <div class="upload-icon">
                                    <img src="{{ asset('assets') }}/icons/cloud-arrow-up.svg" alt="Upload Icon">
                                </div>
                            </div>
                        </div>
                        @error('id_verification_file')
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

                    <div class="col-md-12">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation"
                            id="password_confirmation" placeholder="Enter your password again" required />
                        @error('password_confirmation')
                            <div class="text-danger fs-7">{{ $message }}</div>
                        @enderror
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

    <script>
        const input = document.getElementById('id_verification_file');
        const label = document.getElementsByClassName('upload-text')[0];
        const submitBtn = document.forms[0].querySelector('button[type="submit"]');

        const isValidEmail = (email) => {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        const checkUserExists = () => {
            let email = $('#email').val().trim();

            if (email.length == 0 || !isValidEmail(email)) {
                $('#email-exists-error').text('');
                $('#email-exists-success').text('');
                submitBtn.disabled = false;
                return false;
            }

            $.ajax({
                type: "POST",
                url: "{{ route('users.check') }}",
                data: {
                    email
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(data) {
                console.log(data.exists);
                if (data.exists) {
                    $('#email-exists-success').text('');
                    $('#email-exists-error').text('Email already exists');
                    submitBtn.disabled = true;
                } else {
                    $('#email-exists-error').text('');
                    $('#email-exists-success').text('Email is available');
                    submitBtn.disabled = false;
                }
            });
        }

        const updateFileName = () => {
            if (input.files.length > 0) {
                if (!(input.files[0].type == 'application/pdf')) {
                    alert('Only PDF files are allowed');
                    return false;
                }
                label.textContent = input.files[0].name;
            } else {
                label.textContent = 'Upload NID/Office ID for verification';
            }
        }

        const sanitizePhone = (input) => {
            // Remove all non-digit characters, and max 15 digits
            input.value = input.value.replace(/\D/g, '').slice(0, 15);
        }
    </script>
</body>

</html>
