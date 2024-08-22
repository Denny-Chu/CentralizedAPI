<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestHeader extends Model
{
    use HasFactory;

    protected $fillable = [
        'swrr_id',
        'key',
        'value',
    ];

    public function requestRecord()
    {
        return $this->belongsTo(SingleWalletRequestRecord::class, 'swrr_id');
    }
}