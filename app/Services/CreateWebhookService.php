<?php

namespace App\Services;


use App\Events\WalletWebhookCreateEvent;
use Illuminate\Support\Facades\Route;

class CreateWebhookService
{

    public function createWebhook($data)
    {
        WalletWebhookCreateEvent::dispatch($data);
    }

    public function receiveWebhook($request)
    {
        $type = is_array($request) ? ($request['type'] ?? null) : $request->input('type');
        $payload = is_array($request) ? ($request['data'] ?? null) : $request->input('data');

        if (!$type || !$payload) {
            return null;
        }

        return app('App\\WalletEngine\\Wallet')
            ->getWalletType($type)
            ->convertWalletWebHookToHandleRowInDB($payload);
    }

}