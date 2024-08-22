<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SingleWalletSet extends Model
{
    use HasFactory;

    protected $table = 'single_wallet_set';

    protected $fillable = [
        'cagent_uid',
        'platform',
        'method',
        'callback_url',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    // 如果需要，可以添加與其他模型的關係
    public function cagent()
    {
        return $this->belongsTo(Cagent::class, 'cagent_uid', 'uid');
    }
}