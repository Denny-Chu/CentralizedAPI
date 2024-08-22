<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Whitelists extends Model
{
    use HasFactory;

    protected $hidden = ['last_editor'];

    protected $table = 'white_lists';

    protected $fillable = ['ip_address', 'cagent_uid', 'description', 'is_active', 'last_editor'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function lastEditor(): BelongsTo
    {
        return $this->belongsTo(cagent::class, 'last_editor', 'uid');
    }
}