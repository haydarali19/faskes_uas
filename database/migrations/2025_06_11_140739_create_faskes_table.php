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
        Schema::create('faskes', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('nama_pengelola', 45);
            $table->string('alamat', 100);
            $table->string('website', 45)->nullable();
            $table->string('email', 45)->nullable();
            $table->integer('rating')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->unsignedBigInteger('kabkota_id');
            $table->unsignedBigInteger('jenis_faskes_id');
            $table->foreign('kabkota_id')->references('id')->on('kabkotas')->onDelete('cascade');
            $table->foreign('jenis_faskes_id')->references('id')->on('jenis_faskes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faskes');
    }
};
