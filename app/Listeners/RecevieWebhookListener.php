<?php

namespace App\Listeners;

use App\Events\RecevieWebhookEvent;
use App\Jobs\SendNotificationsToAdminJop;
use App\Services\CreateWebhookService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Route;

class RecevieWebhookListener
{
    /**
     * Create the event listener.
     */
    protected $createWebhookService;
    public function __construct(CreateWebhookService $createWebhookService)
    {
        $this->createWebhookService = $createWebhookService;
    }

    /**
     * Handle the event.
     */
    public function handle(RecevieWebhookEvent $event): void
    {
        SendNotificationsToAdminJop::dispatch();
    }
}
