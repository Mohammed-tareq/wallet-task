<?php

namespace App\Http\Requests;

use App\Enum\WalletTypeEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class WalletRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', Rule::in([
                WalletTypeEnum::ACME->value,
                WalletTypeEnum::PAYTECH->value,
            ])],
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'account_number' => 'required|integer',
            'debt_payment' => 'sometimes|string|max:50',
            'internal_reference' => 'sometimes|string|max:100',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            $response = response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()->messages(),
            ], 422);

            throw new HttpResponseException($response);
        }
    }
}
