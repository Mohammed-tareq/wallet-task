<?php

namespace App\Repositories;

use App\Models\PayTech;

class PayTechRepository
{
    public function createPayTech($result, $notes)
    {
        $payTeachWallet = PayTech::create([
            'transaction_date' => $result['date'],
            'amount' => $result['amount'],
            'account_number' => $result['account_number'],
            'notes' => $notes,
        ]);
        return $payTeachWallet;
    }

}