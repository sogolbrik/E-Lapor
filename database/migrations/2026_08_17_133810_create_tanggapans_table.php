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
        Schema::create('tanggapans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aduan_id')->constrained('aduans')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID Petugas/Admin
            $table->text('tanggapan');
            $table->string('foto_bukti')->nullable(); // Foto pengerjaan/tindak lanjut
            $table->enum('status_sebelumnya', ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'])->nullable();
            $table->enum('status_setelahnya', ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanggapans');
    }
};
