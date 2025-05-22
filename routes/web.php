<?php

use App\Http\Controllers\Admin\DashboardControler;
use App\Http\Controllers\Admin\DataBarangController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PemasukanController;
use App\Http\Controllers\Admin\PengeluaranController;
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
