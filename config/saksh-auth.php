<?php

return [
    'otp_expiry' => env('SAKSH_AUTH_OTP_EXPIRY', 300), // OTP expiry in seconds
    'otp_length' => env('SAKSH_AUTH_OTP_LENGTH', 6),   // OTP length
    'driver' => env('SAKSH_AUTH_DRIVER', 'email'),      // e.g., email, sms
];