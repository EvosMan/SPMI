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
            'kegiatan' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'required|string',
            'reschedule_reason' => 'required|string',
        ]);

        $audit->update([
            'kegiatan' => $request->kegiatan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'lokasi' => $request->lokasi,
            'reschedule_reason' => $request->reschedule_reason,
            'status' => 'Proses',
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
            'kegiatan' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'required|string',
            'reject_reason' => 'required|string',
        ]);

        $audit->update([
            'kegiatan' => $request->kegiatan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'lokasi' => $request->lokasi,
            'reject_reason' => $request->reject_reason,
            'status' => 'Proses',
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
        $query = JadwalAudit::query();

        if (auth()->user()->hasRole('kaprodi')) {
            $query->where('v_kaprodi', 'Belum Divalidasi');
        } elseif (auth()->user()->hasRole('auditor')) {
            $query->where('v_kaprodi', 'Sudah Divalidasi');
            $query->where('status_pelaksanaan', 'Belum');
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('kegiatan', fn($data) => $data->kegiatan)
            ->addColumn('tanggal', fn($data) => $data->tanggal_mulai . ' - ' . $data->tanggal_selesai)
            ->addColumn('lokasi', fn($data) => $data->lokasi)
            ->addColumn('keterangan', fn($data) => $data->keterangan)
            ->addColumn('status', fn($data) => $data->status ?? '-')
            ->addColumn('auditor', fn($data) => $data->user->name ?? 'Tidak Diketahui')
            ->addColumn('v_kaprodi', fn($data) => $data->v_kaprodi)
            ->addColumn('reschedule_reason', fn($data) => $data->reschedule_reason)
            ->addColumn('reject_reason', fn($data) => $data->reject_reason)
            ->addColumn('status_pelaksanaan', fn($data) => $data->status_pelaksanaan)
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

    public function datatableReschedule()
    {
        $user = auth()->user();
        if (!(method_exists($user, 'hasRole') && $user->hasRole('auditor'))) {
            abort(403, 'Unauthorized');
        }

        $query = JadwalAudit::where('status', 'Reschedule');
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('kegiatan', fn($data) => $data->kegiatan)
            ->addColumn('tanggal', fn($data) => $data->tanggal_mulai . ' - ' . $data->tanggal_selesai)
            ->addColumn('lokasi', fn($data) => $data->lokasi)
            ->addColumn('reason', fn($data) => $data->reschedule_reason)
            ->addColumn('status', fn($data) => $data->status)
            ->addColumn('action', fn($data) => view('components.datatable.action', [
                'urlEdit' => route('audit.reschedule.edit', $data->id),
            ]))
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatableReject()
    {
        $user = auth()->user();
        if (!(method_exists($user, 'hasRole') && $user->hasRole('auditor'))) {
            abort(403, 'Unauthorized');
        }

        $query = JadwalAudit::where('status', 'Ditolak');
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('kegiatan', fn($data) => $data->kegiatan)
            ->addColumn('tanggal', fn($data) => $data->tanggal_mulai . ' - ' . $data->tanggal_selesai)
            ->addColumn('lokasi', fn($data) => $data->lokasi)
            ->addColumn('reason', fn($data) => $data->reject_reason)
            ->addColumn('status', fn($data) => $data->status)
            ->addColumn('action', fn($data) => view('components.datatable.action', [
                'urlEdit' => route('audit.reject.edit', $data->id),
            ]))
            ->rawColumns(['action'])
            ->make(true);
    }
}
