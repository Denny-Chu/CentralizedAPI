<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberInfo extends Model
{
    protected $table = 'member_info';

    protected $primaryKey = 'uid';

    public $incrementing = true;

    public $timestamps = false;

    protected $casts = [
        'tags' => 'array',
    ];

    protected $hidden = ['passwd']; //回傳資料時不顯示區域

    protected $fillable = [
        'birthday',
        'country',
        'create_time',
        'create_ts',
        'email',
        'memId',
        'mobile',
        'name',
        'passwd',
        'cagent_uid',
    ];

}
