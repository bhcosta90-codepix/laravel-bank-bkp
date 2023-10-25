<?php

namespace App\Http\Resources;

use App\Models\Enum\Transaction\TypeTransactionEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $type = isset($this->type)
            ? TypeTransactionEnum::from($this->type)
            : null;

        return [
            'id' => (string) $this->id,
            'account_id' => $this->account_id ?? $this->accountFrom,
            'debit_id' => $this->debit_id ?? $this->debit ?? null,
            'value' => $type ? ($type == TypeTransactionEnum::DEBIT ? $this->value * -1 : $this->value) : null,
            'kind' => $this->kind,
            'type' => $type,
            'key' => $this->key,
            'description' => $this->description,
            'status' => $this->status,
            'cancel_description' => $this->cancel_description ?? $this->cancelDescription ?? null,
            'created_at' => $this->created_at ?? $this->createdAt(),
        ];
    }
}
