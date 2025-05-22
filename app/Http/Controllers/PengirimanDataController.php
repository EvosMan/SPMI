<?php

namespace App\Http\Controllers;

use App\Models\PengirimanData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class PengirimanDataController extends Controller
{
    public function index()
    {
        return view('pages.pengiriman-data.index');
    }
    public function create(Request $request)
    {
        return view('pages.pengiriman-data.form', [
            'data' => new PengirimanData(),
        ]);
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            PengirimanData::create($validate);
            DB::commit();
            return redirect()->route('kategori.index')->with('success', 'Kategori Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kategori.index')->with('error', 'Kategori Gagal Ditambahkan');
        }
    }

    public function show(PengirimanData $data)
    {
        return view('pages.pengiriman-data.show', compact('kategori'));
    }

    public function edit(PengirimanData $data)
    {
        return view('pages.pengiriman-data.form', compact('kategori'));
    }
    public function update(Request $request, PengirimanData $data)
    {
        $validate = $request->validate([
            'nama' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            $data->update($validate);
            DB::commit();
            return redirect()->route('kategori.index')->with('success', 'Kategori Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kategori.index')->with('error', 'Kategori Gagal Diupdate');
        }
    }

    public function destroy(PengirimanData $data)
    {
        DB::beginTransaction();
        try {
            $data->delete();
            DB::commit();
            return redirect()->route('kategori.index')->with('success', 'Kategori Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kategori.index')->with('error', 'Kategori Gagal Diupdate');
        }
    }

    public function datatable()
    {
        $query =  PengirimanData::query();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('components.datatable.action', [
                    'urlEdit'   => route('kategori.edit', $data->id),
                    'urlDelete' => route('kategori.destroy', $data->id),
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
