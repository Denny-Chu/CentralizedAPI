<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('response_records', function (Blueprint $table) {
            $table->id(); // 自增主鍵
            $table->foreignId('swrr_id')->comment('關聯的single_wallet_request_records表的ID')
                  ->constrained('single_wallet_request_records')
                  ->onDelete('cascade');
            $table->integer('status_code')->comment('HTTP響應狀態碼');
            $table->json('headers')->comment('響應頭部，以JSON格式存儲');
            $table->text('body')->comment('響應體內容');
            $table->timestamps(); // 創建和更新時間戳
        });
    }

    public function down()
    {
        Schema::dropIfExists('response_records');
    }
};