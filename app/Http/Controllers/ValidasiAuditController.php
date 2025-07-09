<?php

namespace App\Http\Controllers;

use App\Models\JadwalAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ValidasiAuditController extends Controller
{
    public function index()
    {
        return view('pages.validasi-audit.index');
    }

    public function update(Request $request, JadwalAudit $audit)
    {
        $data = [];

        if (auth()->user()->hasRole('kaprodi')) {
            $data['v_kaprodi'] = 'Sudah Divalidasi';
        } elseif (auth()->user()->hasRole('auditor')) {
            $data['status_pelaksanaan'] = $request['status_pelaksanaan'];
        } else {
            return redirect()->route('validasiAudit.index')->with('error', 'Anda tidak memiliki akses untuk melakukan validasi audit');
        }

        DB::beginTransaction();
        try {
            $audit->update($data);

            // Ambil data terbaru setelah update
            $audit->refresh();

            // Cek semua validasi sudah dilakukan
            if (
                $audit->v_kaprodi === 'Sudah Divalidasi' &&
                $audit->status_pelaksanaan === 'Sudah Dilaksanakan'
            ) {
                $audit->update(['status' => 'Tercapai']);
            }

            DB::commit();
            return redirect()->route('validasiAudit.index')->with('success', 'Audit Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('validasiAudit.index')->with('error', 'Audit Gagal Diupdate');
        }
    }

    public function datatable()
    {
        $query =  JadwalAudit::query();
        if (auth()->user()->hasRole('kaprodi')) {
            $query->where('v_kaprodi', 'Belum Divalidasi');
        } elseif (auth()->user()->hasRole('auditor')) {
            $query->where('v_kaprodi', 'Sudah Divalidasi');
            $query->where('status_pelaksanaan', 'Belum');
        }
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('kegiatan', function ($data) {
                return $data->kegiatan;
            })
            ->addColumn('tanggal', function ($data) {
                return $data->tanggal_mulai . ' - ' . $data->tanggal_selesai;
            })
            ->addColumn('lokasi', function ($data) {
                return $data->lokasi;
            })
            ->addColumn('audit', function ($data) {
                return 'Audit ' . $data->kegiatan;
            })
            ->addColumn('auditor', function ($data) {
                return $data->user->name ?? 'Tidak Diketahui';
            })
            ->addColumn('status', function ($data) {
                return $data->status ?? '-';
            })
            ->addColumn('action', function ($data) {
                if (auth()->user()->hasRole('auditor')) {
                    return view('components.datatable.action', [
                        'urlPelaksanaan' => route('validasiAudit.update', $data->id),
                    ]);
                }
                return view('components.datatable.action', [
                    'urlValidasi' => route('validasiAudit.update', $data->id),
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
