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
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->json('value')->nullable();
            $table->unsignedBigInteger('kpi_id')->nullable()->unsigned();
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('type_id');
            $table->timestamps();
        });
        Schema::table('parameters', function ($table){
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade')->onDelete('cascade');
            $table->foreign('kpi_id')->references('id')->on('kpis')->onDelete('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
};
