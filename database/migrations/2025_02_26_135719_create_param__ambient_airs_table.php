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
        Schema::create('param__ambient_airs', function (Blueprint $table) {
            $table->id();
            $table->string('testing_result')->nullable();
            $table->string('coordinate')->nullable();
            $table->string('temparature')->nullable();
            $table->string('pressure')->nullable();
            $table->string('humidity')->nullable();
            $table->string('wind_speed')->nullable();
            $table->string('wind_direction')->nullable();
            $table->string('weather')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('param__ambient_airs');
    }
};
