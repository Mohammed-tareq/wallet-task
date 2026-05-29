<?php

namespace App\WalletEngine\Classes;

use App\Services\PayTechService;
use App\WalletEngine\contracts\WalletContract;

class PayTech extends WalletContract

{
    protected PayTechService $payTechService;

    public function __construct(PayTechService $payTechService)
    {
        $this->payTechService = $payTechService;
    }


    public function createWalletResponse($request)
    {
        return $this->convertWalletWebHookToHandleRowInDB($request);

    }

    public function convertRequestToWalletWebHook($request)
    {
        // Convert the incoming request to a format suitable for processing as a wallet webhook.
        /**
         * 20250615156,50#202506159000001#note/debt payment march/internal_reference/A462JE81
         * logic to convert the request to the target format and return it.
         * cut in # and convert it to array and return it.
         * request => [156.50, (int)202506159000001, (date format)"2025-06-15"]
         *
         */
        $payload =
            today()->format('Ymd')
            . number_format($request['amount'], 2, ',', '')
            . '#'
            . $request['account_number']
            . '#note/'
            . 'debt payment/'
            . $request['debt_payment']
            . '/internal_reference/'
            . $request['internal_reference'];

        return $payload;


    }

    public function convertWalletWebHookToHandleRowInDB($webHook)
    {
        // Convert the wallet webhook to a format suitable for handling as a row in the database.
        /**
         * 20250615156,50#202506159000001#note/debt payment march/internal_reference/A462JE81
         * logic to convert the request to the target format and return it.
         * cut in # and convert it to array and return it.
         * result => [156.50, (int)202506159000001, (date format)"2025-06-15"]
         */

        $parts = explode('#', (string) $webHook);

        if (count($parts) < 3) {
            return null;
        }

        preg_match('/^(\d{8})(.*)$/', $parts[0], $matches);

        if (!isset($matches[1], $matches[2])) {
            return null;
        }

        $date = $matches[1];
        $amount = (float) str_replace(',', '.', $matches[2]);
        $accountNumber = $parts[1] ?? null;

        if ($accountNumber === null || $accountNumber === '') {
            return null;
        }

        $noteParts = explode('/', $parts[2] ?? '');
        $notes = [];

        for ($i = 1, $len = count($noteParts); $i < $len; $i += 2) {
            $key = str_replace(' ', '_', $noteParts[$i]);
            $notes[$key] = $noteParts[$i + 1] ?? null;
        }

        $result = array_merge([
            'date' => date('Y-m-d', strtotime($date)),
            'amount' => $amount,
            'account_number' => $accountNumber,
            'type' => 'paytech',
            'user_id' => auth()->id(),
            'user_name' => auth()->user()?->name,
        ], $notes);

        return $this->payTechService->createPayTech($result, $notes);

    }

}