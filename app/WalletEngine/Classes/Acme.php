<?php

namespace App\WalletEngine\Classes;

use App\Services\AcmeService;
use App\WalletEngine\contracts\WalletContract;

class Acme extends WalletContract

{
    protected AcmeService $acmeService;

    public function __construct(AcmeService $acmeService)
    {
        $this->acmeService = $acmeService;
    }

    public function createWalletResponse($request)
    {
        return $this->convertWalletWebHookToHandleRowInDB($request);
    }

    public function convertRequestToWalletWebHook($request)
    {
        // Convert the incoming request to a format suitable for processing as a wallet webhook.
        /**
         * 156,50//202506159000001//20250615 => target
         * logic to convert the request to the target format and return it.
         * cut in // and convert it to array and return it.
         * request => [156.50, (int)202506159000001, (date format)"2025-06-15"]
         *
         */
        $data =
            number_format($request['amount'], 2, ',', '')
            . '//'
            . $request['account_number']
            . '//'
            . str_replace('-', '', $request['date']);

        return $data;
    }

    public function convertWalletWebHookToHandleRowInDB($webHook)
    {
        // Convert the wallet webhook to a format suitable for handling as a row in the database.
        /**
         * 156,50//202506159000001//20250615 => target
         * logic to convert the request to the target format and return it.
         * cut in // and convert it to array and return it.
         * result => [156.50, (int)202506159000001, (date format)"2025-06-15"]
         */
        $data = explode('//', (string) $webHook);

        if (count($data) < 3) {
            return null;
        }

        $result = [
            'amount' => str_replace(',', '.', $data[0]),
            'account_number' => (int)$data[1],
            'date' => date('Y-m-d', strtotime($data[2])),
            'type' => 'acme',
        ];
        $result = array_merge($result, $this->getUserAuthenticated());  

        return $this->acmeService->createAcme($result);
    }

    public function getUserAuthenticated()
    {
        return [
            'user_id' => auth()->id(),
            'user_name' => auth()->user()?->name,
        ];
    }
}