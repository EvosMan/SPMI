<?php

namespace App\Http\Controllers;

use App\Models\Evaluasi;
use App\Models\JadwalAudit;
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
        $query =  Evaluasi::with('detailEvaluasi'); // pastikan relasi eager loaded
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('user', function ($data) {
                // return
            })
            ->addColumn('action', function ($data) {
                $user = auth()->user();

                // Tombol Cetak hanya muncul jika semua detailEvaluasi sudah punya hasilEvaluasi
                $bolehCetak = $data->detailEvaluasi->count() > 0 &&
                    $data->detailEvaluasi->every(function ($detail) {
                        return !empty($detail->hasilEvaluasi);
                    });

                if ($user->hasRole('staf') && $bolehCetak) {
                    return view('components.datatable.action', [
                        'urlCetak' => route('evaluasi.cetak', $data->id),
                    ]);
                }
                if ($user->hasRole('kaprodi')) {
                    $actions = [];

                    if ($bolehCetak) {
                        $actions['urlCetak'] = route('evaluasi.cetak', $data->id);
                    }

                    $actions['urlPilih'] = route('kaprodi-evaluasi.edit', $data->id);

                    return view('components.datatable.action', $actions);
                }
                return '-';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatableAudit()
    {
        $query = JadwalAudit::with('user');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('kegiatan', function ($data) {
                return $data->kegiatan ?? '-';
            })
            ->addColumn('tanggal', function ($data) {
                return $data->tanggal_mulai . ' - ' . $data->tanggal_selesai;
            })
            ->addColumn('lokasi', function ($data) {
                return $data->lokasi ?? '-';
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
