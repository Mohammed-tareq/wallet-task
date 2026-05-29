<?php

namespace App\Services;

use App\Repositories\PayTechRepository;
use Illuminate\Support\Facades\DB;

class PayTechService
{
    protected PayTechRepository $payTechRepository;
    protected UserPaymentWalletService $userPaymentWalletService;

    public function __construct(PayTechRepository $payTechRepository, UserPaymentWalletService $userPaymentWalletService)
    {
        $this->payTechRepository = $payTechRepository;
        $this->userPaymentWalletService = $userPaymentWalletService;
    }

    public function createPayTech($data, $notes)
    {
        try {
            DB::beginTransaction();
            $payTechData = $this->payTechRepository->createPayTech($data, $notes);
            $userPaymentWallet = $this->userPaymentWalletService->createUserPaymentWallet($payTechData ,$data);
            DB::commit();
            return $userPaymentWallet;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}