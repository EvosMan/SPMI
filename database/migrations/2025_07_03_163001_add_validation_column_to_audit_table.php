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
        Schema::table('feedback', function (Blueprint $table) {
            $table->string('v_kaprodi')->default('Belum Divalidasi')->after('status');
            $table->string('v_staf')->default('Belum Divalidasi')->after('v_kaprodi');
            $table->string('status_pelaksanaan')->default('Belum')->after('v_staf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropColumn(['v_kaprodi', 'v_staf', 'status_pelaksanaan']);
        });
    }
};
