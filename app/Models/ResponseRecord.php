<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'swrr_id',
        'status_code',
        'headers',
        'body',
    ];

    protected $casts = [
        'headers' => 'array',
    ];

    public function requestRecord()
    {
        return $this->belongsTo(SingleWalletRequestRecord::class, 'swrr_id');
    }
}