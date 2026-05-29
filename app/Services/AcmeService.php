<?php

namespace App\Services;

use App\Repositories\AcmeRepository;
use Illuminate\Support\Facades\DB;

class AcmeService
{
    protected AcmeRepository $acmeRepository;
    protected UserPaymentWalletService $userPaymentWalletService;

    public function __construct(AcmeRepository $acmeRepository, UserPaymentWalletService $userPaymentWalletService)
    {
        $this->acmeRepository = $acmeRepository;
        $this->userPaymentWalletService = $userPaymentWalletService;
    }

    public function createAcme(array $data)
    {
        try {
            DB::beginTransaction();
            $acmeData = $this->acmeRepository->createAcme($data);
            $userPaymentWallet = $this->userPaymentWalletService->createUserPaymentWallet($acmeData,$data);
            DB::commit();
            return $userPaymentWallet;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}