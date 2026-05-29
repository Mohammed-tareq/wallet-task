<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayTech extends Model
{
    protected $fillable = ['amount', 'account_number', 'transaction_date', 'notes'];

    protected $casts = [
        'notes' => 'array',
    ];


    public function userPaymentWallet()
    {
        return $this->morphOne(UserPaymentWallet::class, 'walletable');
    }
}
