<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use App\Models\Evaluasi;
use App\Models\JadwalAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardControler extends Controller
{

    public function index()
    {
        $countDokumen = Dokumen::count();
        $countEvaluasi = Evaluasi::count();
        $countAudit = JadwalAudit::count();
        return view('admin.dashboard.index', compact('countDokumen', 'countEvaluasi', 'countAudit'));
    }
}
