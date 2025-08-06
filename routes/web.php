    
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
    use App\Http\Controllers\ValidasiAuditController;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;


    Route::get('/', function () {
        return redirect('/login');
    });

    Auth::routes();
    Route::middleware(['auth'])->group(function () {
        // Halaman auditor: reschedule dan penolakan audit
        Route::get('audit-reschedule', function () {
            return view('pages.audit-reschedule');
        })->name('audit.reschedule.view');
        Route::get('audit-reject', function () {
            return view('pages.audit-reject');
        })->name('audit.reject.view');
        // Edit forms for reschedule/reject
        Route::get('audit-reschedule/{audit}/edit', [ValidasiAuditController::class, 'editReschedule'])->name('audit.reschedule.edit');
        Route::put('audit-reschedule/{audit}', [ValidasiAuditController::class, 'updateReschedule'])->name('audit.reschedule.update');
        Route::get('audit-reject/{audit}/edit', [ValidasiAuditController::class, 'editReject'])->name('audit.reject.edit');
        Route::put('audit-reject/{audit}', [ValidasiAuditController::class, 'updateReject'])->name('audit.reject.update');

        // Endpoint datatable untuk auditor
        Route::get('datatable/audit-reschedule', [ValidasiAuditController::class, 'datatableReschedule'])->name('audit.reschedule');
        Route::get('datatable/audit-reject', [ValidasiAuditController::class, 'datatableReject'])->name('audit.reject');
        Route::get('dashboard', [DashboardControler::class, 'index'])->name('dashboard.index');

        Route::prefix('dokumen')->group(function () {
            Route::get('/download/{dokumen}', [DokumenController::class, 'download'])->name('dokumen.download');

            Route::get('/{type}', [DokumenController::class, 'index'])->name('dokumen.type.index');
            Route::get('/{type}/create', [DokumenController::class, 'create'])->name('dokumen.type.create');
            Route::post('/{type}', [DokumenController::class, 'store'])->name('dokumen.type.store');
            Route::get('/{type}/{dokumen}/edit', [DokumenController::class, 'edit'])->name('dokumen.type.edit');
            Route::put('/{type}/{dokumen}', [DokumenController::class, 'update'])->name('dokumen.type.update');
            Route::delete('/{type}/{dokumen}', [DokumenController::class, 'destroy'])->name('dokumen.type.destroy');
        })->where('type', 'kebijakan|standar|manual|formulir');

        Route::resource('manajemen-evaluasi', EvaluasiController::class)->names('evaluasi')->parameters(['manajemen-evaluasi' => 'evaluasi']);
        Route::get('manajemen-evaluasi-cetak/{id}', [EvaluasiController::class, 'cetak'])->name('evaluasi.cetak');
        Route::resource('evaluasi/{evaluasi}/detail-evaluasi', DetailEvaluasiController::class)->names('detailEvaluasi')->parameters(['detail-evaluasi' => 'detailEvaluasi']);
        Route::resource('jadwal-audit', JadwalAuditController::class)->names('jadwalAudit')->parameters(['jadwal-audit' => 'audit']);
        Route::resource('audit', AuditController::class);
        Route::get('audit-cetak/{audit}', [AuditController::class, 'cetak'])->name('audit.cetak');
        Route::resource('validasi-audit', ValidasiAuditController::class)->only('index', 'update')->names('validasiAudit')->parameters(['validasi-audit' => 'audit']);
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
            Route::get('validasi-audit', [ValidasiAuditController::class, 'datatable'])->name('validasiAudit.datatable');
            Route::get('data', [PengirimanDataController::class, 'datatable'])->name('data.datatable');
            Route::get('user', [UserController::class, 'datatable'])->name('user.datatable');
        });
    });
// Route::get('user', [UserController::class, 'datatable'])->name('user.datatable');
