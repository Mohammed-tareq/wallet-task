<?php

namespace App\WalletEngine;

use App\Enum\WalletTypeEnum;
use App\WalletEngine\Classes\Acme;
use App\WalletEngine\Classes\PayTech;

class Wallet
{
    protected array $wallets;
    public function __construct()
    {
        $this->wallets = [
            WalletTypeEnum::ACME->value => app(Acme::class),
            WalletTypeEnum::PAYTECH->value => app(PayTech::class),
        ];
    }

    public function getWalletType($type)
    {

        return $this->wallets[$type];
    }

    public function createWallet($data)
    {
        $walletResponse = $this->getWalletType($data['type'])->createWalletResponse($data);
        return $walletResponse;
    }

    public function createWebhookResponse ($type, $request)
    {
        $walletWebhookResponse = $this->getWalletType($type)->convertRequestToWalletWebHook($request);
        return $walletWebhookResponse;
    }

}