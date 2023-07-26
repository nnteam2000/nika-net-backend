<?php

namespace App\Jobs;

use App\Mail\EmailVerification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessVerifyEmail implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $uniqueFor = 5;
    public $tries = 3;
    public $timeout = 60;

    public function __construct(protected Authenticatable $user)
    {
    }

    public function uniqueId(): string
    {
        return $this->user->id;
    }

    public function handle(): void
    {
        event(new Registered($this->user));
    }
}