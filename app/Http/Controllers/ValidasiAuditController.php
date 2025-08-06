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

    // Edit form untuk reschedule
    public function editReschedule(JadwalAudit $audit)
    {
        return view('pages.audit-reschedule-edit', compact('audit'));
    }

    // Update reschedule, kembalikan ke validasi kaprodi
    public function updateReschedule(Request $request, JadwalAudit $audit)
    {
        $request->validate([
            'reschedule_reason' => 'required|string',
        ]);
        $audit->update([
            'reschedule_reason' => $request->reschedule_reason,
            'status' => 'Proses', // status agar hilang dari tabel reschedule auditor
            'v_kaprodi' => 'Belum Divalidasi',
        ]);
        return redirect()->route('validasiAudit.index')->with('success', 'Audit berhasil dikembalikan ke validasi kaprodi.');
    }

    // Edit form untuk reject
    public function editReject(JadwalAudit $audit)
    {
        return view('pages.audit-reject-edit', compact('audit'));
    }

    // Update reject, kembalikan ke validasi kaprodi
    public function updateReject(Request $request, JadwalAudit $audit)
    {
        $request->validate([
            'reject_reason' => 'required|string',
        ]);
        $audit->update([
            'reject_reason' => $request->reject_reason,
            'status' => 'Proses', // status agar hilang dari tabel reject auditor
            'v_kaprodi' => 'Belum Divalidasi',
        ]);
        return redirect()->route('validasiAudit.index')->with('success', 'Audit berhasil dikembalikan ke validasi kaprodi.');
    }

    public function update(Request $request, JadwalAudit $audit)
    {
        $data = [];
        $user = auth()->user();

        if (method_exists($user, 'hasRole') && $user->hasRole('kaprodi')) {
            $action = $request->input('action'); // 'setuju', 'reschedule', 'tolak'
            if ($action === 'setuju') {
                $data['v_kaprodi'] = 'Sudah Divalidasi';
                $data['status'] = 'Menunggu Pelaksanaan';
                $data['reschedule_reason'] = null;
                $data['reject_reason'] = null;
            } elseif ($action === 'reschedule') {
                $data['v_kaprodi'] = 'Reschedule';
                $data['status'] = 'Reschedule';
                $data['reschedule_reason'] = $request->input('reason');
                $data['reject_reason'] = null;
            } elseif ($action === 'tolak') {
                $data['v_kaprodi'] = 'Ditolak';
                $data['status'] = 'Ditolak';
                $data['reject_reason'] = $request->input('reason');
                $data['reschedule_reason'] = null;
            } else {
                return redirect()->route('validasiAudit.index')->with('error', 'Aksi tidak valid');
            }
        } elseif (method_exists($user, 'hasRole') && $user->hasRole('auditor')) {
            $data['status_pelaksanaan'] = $request['status_pelaksanaan'];
        } else {
            return redirect()->route('validasiAudit.index')->with('error', 'Anda tidak memiliki akses untuk melakukan validasi audit');
        }

        DB::beginTransaction();
        try {
            $audit->update($data);
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
            ->addColumn('keterangan', function ($data) {
                return $data->keterangan;
            })
            ->addColumn('status', function ($data) {
                return $data->status ?? '-';
            })
            ->addColumn('auditor', function ($data) {
                return $data->user->name ?? 'Tidak Diketahui';
            })
            ->addColumn('v_kaprodi', function ($data) {
                return $data->v_kaprodi;
            })
            ->addColumn('reschedule_reason', function ($data) {
                return $data->reschedule_reason;
            })
            ->addColumn('reject_reason', function ($data) {
                return $data->reject_reason;
            })
            ->addColumn('status_pelaksanaan', function ($data) {
                return $data->status_pelaksanaan;
            })
            ->addColumn('action', function ($data) {
                if (auth()->user()->hasRole('auditor')) {
                    return view('components.datatable.action', [
                        'urlPelaksanaan' => route('validasiAudit.update', $data->id),
                        'rowId' => $data->id,
                    ]);
                }
                return view('components.datatable.action', [
                    'urlValidasi' => route('validasiAudit.update', $data->id),
                    'rowId' => $data->id,
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    // Datatable untuk audit yang di-reschedule (khusus auditor)
    public function datatableReschedule()
    {
        $user = auth()->user();
        if (!(method_exists($user, 'hasRole') && $user->hasRole('auditor'))) {
            abort(403, 'Unauthorized');
        }
        $query = JadwalAudit::where('status', 'Reschedule');
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
            ->addColumn('reason', function ($data) {
                return $data->reschedule_reason;
            })
            ->addColumn('status', function ($data) {
                return $data->status;
            })
            ->addColumn('action', function ($data) {
                return view('components.datatable.action', [
                    'urlEdit' => route('audit.reschedule.edit', $data->id),
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Datatable untuk audit yang ditolak (khusus auditor)
    public function datatableReject()
    {
        $user = auth()->user();
        if (!(method_exists($user, 'hasRole') && $user->hasRole('auditor'))) {
            abort(403, 'Unauthorized');
        }
        $query = JadwalAudit::where('status', 'Ditolak');
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
            ->addColumn('reason', function ($data) {
                return $data->reject_reason;
            })
            ->addColumn('status', function ($data) {
                return $data->status;
            })
            ->addColumn('action', function ($data) {
                return view('components.datatable.action', [
                    'urlEdit' => route('audit.reject.edit', $data->id),
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
