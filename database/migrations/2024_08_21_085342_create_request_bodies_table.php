<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('request_bodies', function (Blueprint $table) {
            $table->id(); // 自增主鍵
            $table->foreignId('swrr_id')->comment('關聯的single_wallet_request_records表的ID')
                  ->constrained('single_wallet_request_records')
                  ->onDelete('cascade');
            $table->string('key')->comment('請求體參數的鍵');
            $table->text('value')->comment('請求體參數的值');
            $table->timestamps(); // 創建和更新時間戳
        });
    }

    public function down()
    {
        Schema::dropIfExists('request_bodies');
    }
};