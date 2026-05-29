<?php

namespace App\Services;

use App\Models\Acme;
use App\Models\PayTech;
use App\Repositories\UserPaymentWalletRepository;

class UserPaymentWalletService
{
    protected UserPaymentWalletRepository $userPaymentWalletRepository;

    public function __construct(UserPaymentWalletRepository $userPaymentWalletRepository)
    {
        $this->userPaymentWalletRepository = $userPaymentWalletRepository;
    }

    public function createUserPaymentWallet(PayTech|Acme $data , $userData = null)
    {
        return $this->userPaymentWalletRepository->createUserPaymentWallet($data , $userData);
    }

}