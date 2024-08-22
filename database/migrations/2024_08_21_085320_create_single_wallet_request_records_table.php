<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('single_wallet_request_records', function (Blueprint $table) {
            $table->id(); // 自增主鍵
            $table->uuid('uuid')->unique()->comment('請求的唯一標識符(Universally unique identifier)');
            $table->string('method')->comment('單一錢包對象方法，例如auth, balance, etc.');
            $table->text('full_request')->comment('完整的請求內容');
            $table->string('request_method')->comment('HTTP請求方法（GET, POST等）');
            $table->string('request_url')->comment('請求的完整URL');
            $table->timestamps(); // 創建和更新時間戳
        });
    }

    public function down()
    {
        Schema::dropIfExists('single_wallet_request_records');
    }
};