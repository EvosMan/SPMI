<?php

namespace App\Http\Controllers;

use App\Models\Evaluasi;
use App\Models\Feedback;
use App\Models\HasilEvaluasi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LaporanMonitoringController extends Controller
{
    public function index()
    {
        return view('pages.laporan.index');
    }

    public function datatable()
    {
        $query =  Evaluasi::query();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('user', function ($data) {
                // return
            })
            ->addColumn('action', function ($data) {
                if ($data->detailEvaluasi->count() > 0 ? $data->detailEvaluasi[0]->hasilEvaluasi : false) {
                    return view('components.datatable.action', [
                        'urlCetak' => route('evaluasi.cetak', $data->id),
                        'urlPilih' => route('kaprodi-evaluasi.edit', $data->id),
                    ]);
                }
                return view('components.datatable.action', [
                    'urlPilih' => route('kaprodi-evaluasi.edit', $data->id),
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatableAudit()
    {
        $query =  Feedback::query()->with('jadwalAudit');
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('tahun', function ($data) {
                return $data->jadwalAudit->tahun;
            })
            ->addColumn('tanggal', function ($data) {
                return $data->jadwalAudit->tanggal_mulai . ' - ' . $data->jadwalAudit->tanggal_selesai;
            })
            ->addColumn('keterangan_Jadwal', function ($data) {
                return $data->jadwalAudit->keterangan;
            })
            ->addColumn('auditor', function ($data) {
                return $data->user->name ?? 'Tidak Diketahui';
            })
            ->addColumn('action', function ($data) {
                if (auth()->user()->hasRole('direktur')) {
                    return view('components.datatable.action', [
                        'urlCetak'  => route('audit.cetak', $data->id),
                        'urlPilih' => route('audit.edit', $data->id),
                    ]);
                }
                return view('components.datatable.action', [
                    'urlPilih' => route('audit.edit', $data->id),
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
