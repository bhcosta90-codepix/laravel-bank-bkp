<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PixKey extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'reference',
        'account_id',
        'kind',
        'key',
    ];
}
