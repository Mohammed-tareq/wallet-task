<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\ArrayToXml\ArrayToXml;

class WalletXMLResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): mixed
    {

        $data = [
            'TransferInfo' => [
                'Reference' => '0212121',
                'Date' => 2025 - 02 - 25,
                'Amount' => 123,
                'Currency' => 'SRC',
            ],
            'SenderInfo' => [
                'AccountNumber' => 'SA6980000204608016212908',
            ],
            'ReceiverInfo' => [
                'BankCode' => 'FDCSSARI',
                'AccountNumber' => 'SA6980000204608016211111',
                'BeneficiaryName' => 'John Doe',
            ]
        ];
        $note = [
            'Note' => 'Payment for invoice #12345',
            'PaymentType' => 'Invoice Payment',
            'ChargeDetails' => 'RB'
        ];
        $data['Notes'] = $note;

        return ArrayToXml::convert($data, 'PaymentRequestMessage', false);

    }
}
