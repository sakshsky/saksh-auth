Below is the full content of the `README.md` file for the `sakshsky/saksh-auth` Laravel package, as requested, provided directly in the chat.

```markdown
# Saksh Auth - OTP-based Laravel Authentication

A Laravel package for passwordless authentication using one-time passwords (OTPs) sent via email.

## Installation

1. Install the package via Composer:
```bash
composer require sakshsky/saksh-auth
```

2. Publish the migrations and configuration:
```bash
php artisan vendor:publish --tag=saksh-auth-migrations
php artisan vendor:publish --tag=saksh-auth-config
```

3. Run the migrations:
```bash
php artisan migrate
```

4. Ensure Laravel Sanctum is installed and configured:
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

## Configuration

The package configuration is located at `config/saksh-auth.php`. You can customize:
- OTP expiry time
- Email subject
- Email template

You can also set these values in your `.env` file:
```env
SAKSH_AUTH_OTP_EXPIRY=10
SAKSH_AUTH_EMAIL_SUBJECT="Your OTP Code"
SAKSH_AUTH_EMAIL_TEMPLATE="Your OTP is: {otp}\n\nThis code will expire at {expires_at}"
```

## API Endpoints

- `POST /otp-auth/request-otp`
  - Parameters: `email`, `name` (optional)
  - Returns: Success message and OTP expiration time

- `POST /otp-auth/verify-otp`
  - Parameters: `email`, `otp`
  - Returns: Access token, token type, and user data

## Events

- `Sakshsky\SakshAuth\Events\OtpGenerated`: Fired when an OTP is generated
- `Sakshsky\SakshAuth\Events\OtpVerified`: Fired when an OTP is verified

## Requirements

- PHP >= 8.0
- Laravel >= 10.0
- Laravel Sanctum

## License

MIT License
```

This `README.md` provides clear instructions for installation, configuration, and usage, along with details about API endpoints, events, requirements, and licensing. If you need modifications (e.g., adding a Packagist badge, contributing guidelines, or a changelog), let me know!
