<?php

namespace App\Http\Controllers;

use App\Models\JadwalAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class JadwalAuditController extends Controller
{
    public function index()
    {
        return view('pages.jadwal-audit.index');
    }
    public function create(Request $request)
    {
        return view('pages.jadwal-audit.form', [
            'audit' => new JadwalAudit(),
        ]);
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'kegiatan' => 'required|string',
            'tanggal_mulai' => 'required|string',
            'tanggal_selesai' => 'required|string',
            'keterangan' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            $validate['user_id'] = auth()->user()->id;
            JadwalAudit::create($validate);
            DB::commit();
            return redirect()->route('jadwalAudit.index')->with('success', 'Jadwal Audit Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
            return redirect()->route('jadwalAudit.index')->with('error', 'Jadwal Audit Gagal Ditambahkan');
        }
    }

    public function show(JadwalAudit $audit)
    {
        return view('pages.jadwal-audit.show', compact('audit'));
    }

    public function edit(JadwalAudit $audit)
    {
        return view('pages.jadwal-audit.form', compact('audit'));
    }
    public function update(Request $request, JadwalAudit $audit)
    {
        $validate = $request->validate([
            'kegiatan' => 'required|string',
            'tanggal_mulai' => 'required|string',
            'tanggal_selesai' => 'required|string',
            'keterangan' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            $audit->update($validate);
            DB::commit();
            return redirect()->route('jadwalAudit.index')->with('success', 'Jadwal Audit Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('jadwalAudit.index')->with('error', 'Jadwal Audit Gagal Diupdate');
        }
    }

    public function destroy(JadwalAudit $audit)
    {
        DB::beginTransaction();
        try {
            $audit->delete();
            DB::commit();
            return redirect()->route('jadwalAudit.index')->with('success', 'Jadwal Audit Berhasil Dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('jadwalAudit.index')->with('error', 'Jadwal Audit Gagal Dihapus');
        }
    }

    public function datatable()
    {
        $query =  JadwalAudit::query();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('user', function ($data) {
                return $data->user->name;
            })
            ->addColumn('action', function ($data) {
                if (auth()->user()->hasRole('staf')) {
                    return '-';
                }
                return view('components.datatable.action', [
                    'urlEdit'   => route('jadwalAudit.edit', $data->id),
                    'urlDelete' => route('jadwalAudit.destroy', $data->id),
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
