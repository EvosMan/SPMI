<?php

namespace App\Http\Controllers;

use App\Models\DetailEvaluasi;
use App\Models\Evaluasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DetailEvaluasiController extends Controller
{
    public function index(Evaluasi $evaluasi)
    {
        return view('pages.detail-evaluasi.index', compact('evaluasi'));
    }
    public function create(Request $request, Evaluasi $evaluasi)
    {
        return view('pages.detail-evaluasi.form', [
            'evaluasi' => $evaluasi,
            'detail' => new DetailEvaluasi(),
        ]);
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'sub_aspek' => 'required|string',
            'evaluasi_id' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            DetailEvaluasi::create($validate);
            DB::commit();
            return redirect()->route('detailEvaluasi.index', $validate['evaluasi_id'])->with('success', 'Evaluasi Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('detailEvaluasi.create', $validate['evaluasi_id'])->with('error', 'Evaluasi Gagal Ditambahkan')->withInput();
        }
    }

    public function show(Evaluasi $evaluasi)
    {
        return view('pages.detail-evaluasi.show', compact('evaluasi'));
    }

    public function edit(Evaluasi $evaluasi, DetailEvaluasi $detailEvaluasi)
    {
        $detail = $detailEvaluasi;
        return view('pages.detail-evaluasi.form', compact('evaluasi', 'detail'));
    }
    public function update(Request $request, Evaluasi $evaluasi, DetailEvaluasi $detailEvaluasi)
    {
        $validate = $request->validate([
            'sub_aspek' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            $detailEvaluasi->update($validate);
            DB::commit();
            return redirect()->route('detailEvaluasi.index', $evaluasi->id)->with('success', 'Evaluasi Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('detailEvaluasi.edit', [$evaluasi->id, $detailEvaluasi->id])->with('error', 'Evaluasi Gagal Diupdate');
        }
    }

    public function destroy(Evaluasi $evaluasi, DetailEvaluasi $detailEvaluasi)
    {
        DB::beginTransaction();
        try {
            $detailEvaluasi->delete();
            DB::commit();
            return redirect()->route('detailEvaluasi.index', $evaluasi->id)->with('success', 'Evaluasi Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('detailEvaluasi.index', [$evaluasi->id, $detailEvaluasi->id])->with('error', 'Evaluasi Gagal Diupdate');
        }
    }

    public function datatable(Request $request)
    {
        $evaluasiId = $request->input('evaluasi_id');
        $query =  DetailEvaluasi::where('evaluasi_id', $evaluasiId);
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('components.datatable.action', [
                    'urlEdit'   => route('detailEvaluasi.edit', [$data->evaluasi_id, $data->id]),
                    'urlDelete' => route('detailEvaluasi.destroy', [$data->evaluasi_id, $data->id]),
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
