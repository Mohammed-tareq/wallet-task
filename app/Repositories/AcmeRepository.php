<?php

namespace App\Repositories;

use App\Models\Acme;

class AcmeRepository
{
    public function createAcme(array $data)
    {
        return Acme::create([
            'transaction_date' => $data['date'],
            'amount' => $data['amount'],
            'account_number' => $data['account_number'],
        ]);
    }

}