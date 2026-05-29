<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\ReceiveWebhookNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;

class SendNotificationsToAdminJop implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users  = User::where('is_admin', true)->get();
        Notification::send($users, new ReceiveWebhookNotification());
    }
}
