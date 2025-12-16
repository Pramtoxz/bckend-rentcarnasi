<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('config_wa', function (Blueprint $table) {
            $table->id();
            $table->string('wa_gateway_url');
            $table->string('wa_gateway_secret');
            $table->string('wa_session_name');
            $table->string('wa_group_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('config_wa');
    }
};
