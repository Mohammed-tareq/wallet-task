<?php

namespace App\WalletEngine\contracts;

abstract class WalletContract
{
    abstract public function convertRequestToWalletWebHook($request);

    abstract public function convertWalletWebHookToHandleRowInDB($webHook);

    abstract public function createWalletResponse($request);
}