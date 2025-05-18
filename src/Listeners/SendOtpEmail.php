<?php 

namespace Sakshsky\SakshAuth\Listeners;

use Sakshsky\SakshAuth\Events\OtpGenerated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendOtpEmail
{
    public function handle(OtpGenerated $event)
    {
        try {
            Mail::raw(
                $this->getEmailContent($event),
                function ($message) use ($event) {
                    $message->to($event->user->email)
                           ->subject(config('saksh-auth.email_subject', 'Your OTP Code'));
                }
            );
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email: ' . $e->getMessage());
        }
    }

    protected function getEmailContent(OtpGenerated $event)
    {
        return config('saksh-auth.email_template', "Your OTP is: {$event->otp}\n\nThis code will expire at {$event->user->otp_expires_at}");
    }
}