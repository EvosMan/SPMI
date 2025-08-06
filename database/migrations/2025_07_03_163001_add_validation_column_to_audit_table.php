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
        Schema::table('jadwal_audits', function (Blueprint $table) {
            $table->string('v_kaprodi')->default('Belum Divalidasi')->after('status');
            $table->string('status_pelaksanaan')->default('Belum')->after('v_kaprodi');
            $table->text('reschedule_reason')->nullable()->after('status_pelaksanaan');
            $table->text('reject_reason')->nullable()->after('reschedule_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_audits', function (Blueprint $table) {
            $table->dropColumn(['v_kaprodi', 'status_pelaksanaan', 'reschedule_reason', 'reject_reason']);
        });
    }
};
