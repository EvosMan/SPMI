<?php

namespace App\Http\Controllers;

use App\Models\Evaluasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class EvaluasiController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('kaprodi')) {
            return view('pages.evaluasi.kaprodi');
        }
        return view('pages.evaluasi.index');
    }
    public function create(Request $request)
    {
        return view('pages.evaluasi.form', [
            'evaluasi' => new Evaluasi(),
        ]);
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'aspek' => 'required|string',
            'tahun' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            Evaluasi::create($validate);
            DB::commit();
            return redirect()->route('evaluasi.index')->with('success', 'Evaluasi Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('evaluasi.create')->with('error', 'Evaluasi Gagal Ditambahkan')->withInput();
        }
    }

    public function show(Evaluasi $evaluasi)
    {
        return view('pages.evaluasi.show', compact('evaluasi'));
    }

    public function edit(Evaluasi $evaluasi)
    {
        return view('pages.evaluasi.form', compact('evaluasi'));
    }
    public function update(Request $request, Evaluasi $evaluasi)
    {
        $validate = $request->validate([
            'aspek' => 'required|string',
            'tahun' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            $evaluasi->update($validate);
            DB::commit();
            return redirect()->route('evaluasi.index')->with('success', 'Evaluasi Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('evaluasi.edit', $evaluasi->id)->with('error', 'Evaluasi Gagal Diupdate');
        }
    }

    public function destroy(Evaluasi $evaluasi)
    {
        DB::beginTransaction();
        try {
            $evaluasi->delete();
            DB::commit();
            return redirect()->route('evaluasi.index')->with('success', 'Evaluasi Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('evaluasi.index')->with('error', 'Evaluasi Gagal Diupdate');
        }
    }

    public function datatable()
    {
        $query =  Evaluasi::query();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                if (auth()->user()->hasRole('kaprodi')) {
                    return view('components.datatable.action', [
                        'urlPilih' => route('kaprodi-evaluasi.edit', $data->id),
                    ]);
                }
                return view('components.datatable.action', [
                    'urlShow'   => route('detailEvaluasi.index', $data->id),
                    'urlEdit'   => route('evaluasi.edit', $data->id),
                    'urlDelete' => route('evaluasi.destroy', $data->id),
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
