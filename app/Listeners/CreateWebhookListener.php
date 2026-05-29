<?php

namespace App\Listeners;

use App\Events\RecevieWebhookEvent;
use App\Events\WalletWebhookCreateEvent;
use App\Jobs\SendNotificationsToAdminJop;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Spatie\WebhookServer\WebhookCall;
use  App\WalletEngine\Wallet;


class CreateWebhookListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WalletWebhookCreateEvent $event): void
    {
        $webhookResponse = app('App\\WalletEngine\\Wallet')->createWebhookResponse($event->data['type'], $event->data);
        WebhookCall::create()
            ->url(route('webhook.receive'))
            ->payload(['data' => $webhookResponse, 'type' => $event->data['type']])
            ->useSecret(config('app.webhook_secret'))
            ->dispatchSync();
        RecevieWebhookEvent::dispatch();

    }
}
