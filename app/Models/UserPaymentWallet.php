<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
#[Fillable(['user_id','user_name', 'walletable_id', 'walletable_type', 'balance'])]
class UserPaymentWallet extends Model
{
    public function walletable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
