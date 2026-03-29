<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman_detail', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peminjaman_id')
                ->references('id')
                ->on('peminjaman')
                ->onDelete('cascade');

            $table->foreignId('alat_id')
                ->references('id')
                ->on('alat')
                ->onDelete('cascade');

            $table->integer('jumlah')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_detail');
    }
};
