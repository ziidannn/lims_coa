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
        Schema::create('coas', function (Blueprint $table) {
            $table->id();
            $table->string('no_coa')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('sample_receive_date')->nullable();
            $table->string('sample_analysis_date')->nullable();
            $table->string('report_date')->nullable();
            $table->string('direktur_id')->nullable();
            $table->string('kode_qr')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coas');
    }
};
