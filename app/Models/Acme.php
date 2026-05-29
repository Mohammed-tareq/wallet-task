<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acme extends Model
{
    protected $fillable = ['amount', 'account_number', 'transaction_date'];

    public function userPaymentWallet()
    {
        return $this->morphMany(UserPaymentWallet::class, 'walletable');
    }
}
