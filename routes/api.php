<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::post('/login', [LoginController::class, 'login']);
Route::post('/wallets', [WalletController::class, 'createWallet'])->middleware('auth:api');
Route::post('/webhook-receive-url', [WalletController::class, 'receiveWebhook'])->name('webhook.receive');
Route::get('/user-wallets', [WalletController::class, 'getUserWallets'])->middleware('auth:api');