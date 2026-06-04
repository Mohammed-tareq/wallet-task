<?php

namespace App\Http\Controllers;

use App\Http\Requests\WalletRequest;
use App\Http\Resources\WalletXMLResource;
use App\Services\CreateWebhookService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;


class WalletController extends Controller
{
    use ApiResponse;

    protected CreateWebhookService $createWebhookService;

    public function __construct(CreateWebhookService $createWebhookService)
    {
        $this->createWebhookService = $createWebhookService;
    }

    public function createWallet(WalletRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['date'] = today()->format('Y-m-d');
        $this->createWebhookService->createWebhook($data);

        return $this->apiresponse('Wallet creation initiated', 200);
    }

    public function receiveWebhook(Request $request)
    {
        $this->receiveWebhookWithLock($request);
    }

    public function receiveWebhookWithLock(Request $request)
    {
        $lock = Cache::lock('webhook-' . Str::uuid(), 120);

        if ($lock->get()) {
            try {
                $data = $this->createWebhookService->receiveWebhook($request);
                \Log::info('Webhook received with data: ' . $data);
                if ($data === null) {
                    return $this->apiresponse('Invalid webhook payload', 400);
                }

                app('App\\WalletEngine\\Wallet')->createWallet($data);
                return $this->apiresponse('Webhook received and processed', 200);
            } finally {
                $lock->release();
            }
        } else {
            return $this->apiresponse('Another process is handling this webhook. Please try again later.', 429);
        }
    }

    public function getUserWallets()
    {
        $wallets = auth()->user()->paymentWallets()->latest()->first();
        return $this->apiresponse('User wallets retrieved successfully', 200, WalletXMLResource::make($wallets));
    }


}
