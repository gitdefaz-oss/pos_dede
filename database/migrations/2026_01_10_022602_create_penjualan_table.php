<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id')->restrictOnDelete();
            $table->integer('total_pembayaran');
            $table->string('metode_pembayaran');
            $table->enum('status', ['OPEN', 'CLOSED']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};