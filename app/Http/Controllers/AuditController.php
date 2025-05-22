<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\JadwalAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AuditController extends Controller
{
    public function index()
    {
        return view('pages.audit.index');
    }

    public function create()
    {
        return view('pages.audit.form', [
            'audit' => new Feedback(),
            'jadwal' => JadwalAudit::get(),
        ]);
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'jadwal_audit_id' => 'required|string',
            'keterangan' => 'required|string',
            'status' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            $validate['user_id'] = auth()->user()->id;
            Feedback::create($validate);
            DB::commit();
            return redirect()->route('audit.index')->with('success', 'Audit Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('audit.create')->with('error', 'Audit Gagal Ditambahkan')->withInput();
        }
    }

    public function show(Feedback $audit)
    {
        return view('pages.audit.show', compact('audit'));
    }

    public function edit(Feedback $audit)
    {
        return view('pages.audit.form', compact('audit'));
    }
    public function update(Request $request, Feedback $audit)
    {
        $validate = $request->validate([
            'jadwal_audit_id' => 'required|string',
            'keterangan' => 'required|string',
            'status' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            $audit->update($validate);
            DB::commit();
            return redirect()->route('audit.index')->with('success', 'Audit Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('audit.edit', $audit->id)->with('error', 'Audit Gagal Diupdate');
        }
    }

    public function destroy(Feedback $audit)
    {
        DB::beginTransaction();
        try {
            $audit->delete();
            DB::commit();
            return redirect()->route('audit.index')->with('success', 'Audit Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('audit.index')->with('error', 'Audit Gagal Diupdate');
        }
    }

    public function datatable()
    {
        $query =  Feedback::query();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('audit', function ($data) {
                return 'Audit Tahun ' .  $data->jadwalAudit->tahun;
            })
            ->addColumn('status', function ($data) {
                return $data->status;
            })
            ->addColumn('action', function ($data) {
                return view('components.datatable.action', [
                    'urlEdit'   => route('audit.edit', $data->id),
                    'urlDelete' => route('audit.destroy', $data->id),
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
