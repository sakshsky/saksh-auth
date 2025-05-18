<?php 
namespace Sakshsky\SakshAuth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Sakshsky\SakshAuth\Events\OtpGenerated;
use Sakshsky\SakshAuth\Events\OtpVerified;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function requestOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'sometimes|required|string|max:255'
        ]);

        $otp = mt_rand(100000, 999999);

        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name ?? explode('@', $request->email)[0],
                'password' => null // No password for OTP auth
            ]
        );

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(config('saksh-auth.otp_expiry', 10))
        ]);

        event(new OtpGenerated($user, $otp));

        return response()->json([
            'message' => 'OTP sent to email.',
            'expires_at' => $user->otp_expires_at
        ], 200);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->otp !== $request->otp) {
            return response()->json(['message' => 'Invalid OTP.'], 401);
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            return response()->json(['message' => 'OTP expired.'], 401);
        }

        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
            'email_verified_at' => $user->email_verified_at ?? now()
        ]);

        event(new OtpVerified($user));

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 200);
    }
}