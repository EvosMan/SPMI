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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('evaluasi_id')->nullable();
            $table->foreignId('jadwal_audit_id')->nullable();
            $table->text('keterangan');
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('jadwal_audit_id')
                  ->references('id')->on('jadwal_audits')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
