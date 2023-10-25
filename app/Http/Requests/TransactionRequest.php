<?php

namespace App\Http\Requests;

use CodePix\Bank\Domain\Entities\Enum\PixKey\KindPixKey;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TransactionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'required',
            'kind' => ['required', new Enum(KindPixKey::class)],
            'key' => 'required',
            'value' => ['required', 'numeric', 'min:0.01'],
        ];
    }
}
