<?php 

namespace Sakshsky\SakshAuth\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class OtpGenerated
{
    use Dispatchable, SerializesModels;

    public $user;
    public $otp;

    public function __construct(User $user, string $otp)
    {
        $this->user = $user;
        $this->otp = $otp;
    }
}