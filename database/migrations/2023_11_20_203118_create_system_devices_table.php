<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('system_id');
            $table->unsignedBigInteger('device_id');
            $table->foreign('system_id')->references('id')
                ->on('systems')->onDelete('cascade');
            $table->foreign('device_id')->references('id')
                ->on('devices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_devices');
    }
};
