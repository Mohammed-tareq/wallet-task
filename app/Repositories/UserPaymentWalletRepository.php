<?php

namespace App\Repositories;

use App\Models\UserPaymentWallet;

class UserPaymentWalletRepository
{
    public function createUserPaymentWallet($data , $userData = null)
    {
        $user = auth()->user();

        return $data->userPaymentWallet()->create([
            'user_id' => $userData['user_id'],
            'user_name' => $userData['user_name']  ?? 'user system',
            'balance' => $data->amount,
        ]);
    }

}