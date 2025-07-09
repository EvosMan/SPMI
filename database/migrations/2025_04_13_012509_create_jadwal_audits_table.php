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
        Schema::create('jadwal_audits', function (Blueprint $table) {
            $table->id();
            $table->string('kegiatan');
            $table->foreignId('user_id');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->text('lokasi');
            $table->text('keterangan');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_audits');
    }
};
