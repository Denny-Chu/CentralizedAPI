<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SingleWalletRequestRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'method',
        'full_request',
        'request_method',
        'request_url',
    ];

    // 如果需要，可以添加與其他模型的關係
    public function headers()
    {
        return $this->hasMany(RequestHeader::class, 'swrr_id');
    }

    public function body()
    {
        return $this->hasMany(RequestBody::class, 'swrr_id');
    }

    public function response()
    {
        return $this->hasOne(ResponseRecord::class, 'swrr_id');
    }
}