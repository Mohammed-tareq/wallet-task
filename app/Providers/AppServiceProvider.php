<?php

namespace App\Providers;

use App\Events\RecevieWebhookEvent;
use App\Events\WalletWebhookCreateEvent;
use App\Listeners\CreateWebhookListener;
use App\Listeners\RecevieWebhookListener;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $listen = [
        WalletWebhookCreateEvent::class => [
            CreateWebhookListener::class,
        ],
        RecevieWebhookEvent::class => [
            RecevieWebhookListener::class,
        ],
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
