<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('request_headers', function (Blueprint $table) {
            $table->id(); // 自增主鍵
            $table->foreignId('swrr_id')->comment('關聯的single_wallet_request_records表的ID')
                  ->constrained('single_wallet_request_records')
                  ->onDelete('cascade');
            $table->string('key')->comment('HTTP頭部的鍵');
            $table->text('value')->comment('HTTP頭部的值');
            $table->timestamps(); // 創建和更新時間戳
        });
    }

    public function down()
    {
        Schema::dropIfExists('request_headers');
    }
};