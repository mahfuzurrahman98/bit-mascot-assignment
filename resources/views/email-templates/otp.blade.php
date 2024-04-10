<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OTP Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .email-container {
            max-width: 600px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div>
            <p>To authenticate, please use the following One Time Password (OTP):</p>
            <p style="font-size: 18px; font-weight: bold;">{{ $otp }}</p>
        </div>

        <div>Don't share this OTP with anyone. We hope to see you again soon.</div>

        <div style="margin-top: 20px">
            Regards, <br> Bit Mascot
        </div>
    </div>
</body>

</html>
