<?php

namespace App\Http\Resources;

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
        return [
            'id' => (string) $this->id,
            'account_id' => $this->account_id ?? $this->accountFrom,
            'debit_id' => $this->debit_id ?? $this->debit ?? null,
            'value' => $this->value,
            'kind' => $this->kind,
            'key' => $this->key,
            'description' => $this->description,
            'status' => $this->status,
            'cancel_description' => $this->cancel_description ?? $this->cancelDescription ?? null,
            'created_at' => $this->created_at ?? $this->createdAt(),
        ];
    }
}
