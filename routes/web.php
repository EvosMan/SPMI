<?php

use App\Http\Controllers\Admin\DashboardControler;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\DetailEvaluasiController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\EvaluasiController;
use App\Http\Controllers\EvaluasiKaprodiController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\JadwalAuditController;
use App\Http\Controllers\LaporanMonitoringController;
use App\Http\Controllers\PengirimanDataController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardControler::class, 'index'])->name('dashboard.index');
    Route::resource('dokumen', DokumenController::class)->names('dokumen')->parameter('dokumen', 'dokumen');
    Route::resource('manajemen-evaluasi', EvaluasiController::class)->names('evaluasi')->parameters(['manajemen-evaluasi' => 'evaluasi']);
    Route::resource('evaluasi/{evaluasi}/detail-evaluasi', DetailEvaluasiController::class)->names('detailEvaluasi')->parameters(['detail-evaluasi' => 'detailEvaluasi']);
    Route::resource('jadwal-audit', JadwalAuditController::class)->names('jadwalAudit')->parameters(['jadwal-audit' => 'audit']);
    Route::resource('audit', AuditController::class);
    Route::resource('kaprodi-evaluasi', EvaluasiKaprodiController::class);
    Route::resource('feedback', FeedbackController::class);
    Route::get('laporan-monitoring', [LaporanMonitoringController::class, 'index'])->name('monitoring.index');
    Route::resource('pengiriman-data', PengirimanDataController::class)->names('data')->parameters(['data' => 'data']);
    Route::resource('user', UserController::class);

    Route::prefix('datatable')->group(function () {
        Route::get('dokumen', [DokumenController::class, 'datatable'])->name('dokumen.datatable');
        Route::get('evaluasi', [EvaluasiController::class, 'datatable'])->name('evaluasi.datatable');
        Route::get('monitoring-evaluasi', [LaporanMonitoringController::class, 'datatable'])->name('monitoring-evaluasi.datatable');
        Route::get('monitoring-audit', [LaporanMonitoringController::class, 'datatableAudit'])->name('monitoringAudit.datatable');
        Route::get('detail-evaluasi', [DetailEvaluasiController::class, 'datatable'])->name('detailEvaluasi.datatable');
        Route::get('audit', [JadwalAuditController::class, 'datatable'])->name('audit.datatable');
        Route::get('audit-feedback', [AuditController::class, 'datatable'])->name('auditFeedback.datatable');
        Route::get('feedback', [FeedbackController::class, 'datatable'])->name('feedback.datatable');
        Route::get('data', [PengirimanDataController::class, 'datatable'])->name('data.datatable');
        Route::get('user', [UserController::class, 'datatable'])->name('user.datatable');
    });
});
