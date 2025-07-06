<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ValidasiAuditController extends Controller
{
    public function index()
    {
        return view('pages.validasi-audit.index');
    }

    public function update(Request $request, Feedback $audit)
    {
        if (auth()->user()->hasRole('kaprodi')) {
            $data['v_kaprodi'] = 'Sudah Divalidasi';
        } elseif (auth()->user()->hasRole('staf')) {
            $data['v_staf'] = 'Sudah Divalidasi';
        } elseif (auth()->user()->hasRole('auditor')) {
            $data['status_pelaksanaan'] = $request['status_pelaksanaan'];
        } else {
            return redirect()->route('validasiAudit.index')->with('error', 'Anda tidak memiliki akses untuk melakukan validasi audit');
        }
        DB::beginTransaction();
        try {
            $audit->update($data);
            DB::commit();
            return redirect()->route('validasiAudit.index')->with('success', 'Audit Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('validasiAudit.index')->with('error', 'Audit Gagal Diupdate');
        }
    }


    public function datatable()
    {
        $query =  Feedback::query();
        if (auth()->user()->hasRole('kaprodi')) {
            $query->where('v_kaprodi', 'Belum Divalidasi');
        } elseif (auth()->user()->hasRole('staf')) {
            $query->where('v_kaprodi', 'Sudah Divalidasi');
            $query->where('v_staf', 'Belum Divalidasi');
        } elseif (auth()->user()->hasRole('auditor')) {
            $query->where('v_kaprodi', 'Sudah Divalidasi');
            $query->where('v_staf', 'Sudah Divalidasi');
            $query->where('status_pelaksanaan', 'Belum');
        }
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
            ->addColumn('audit', function ($data) {
                return 'Audit Tahun ' .  $data->jadwalAudit->tahun;
            })
            ->addColumn('auditor', function ($data) {
                return $data->user->name ?? 'Tidak Diketahui';
            })
            ->addColumn('status', function ($data) {
                return $data->status;
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
