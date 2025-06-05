<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DokumenController extends Controller
{
    public function index()
    {
        return view('pages.dokumen.index');
    }
    public function create(Request $request)
    {
        return view('pages.dokumen.form', [
            'dokumen' => new Dokumen(),
        ]);
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'kategori' => 'required|string',
            'tanggal' => 'required|string',
            'judul' => 'required|string',
            'keterangan' => 'required|string',
            'file' => 'required|file',
        ]);
        DB::beginTransaction();
        try {
            if ($request->hasFile('file')) {
                $filename = time() . '_' . $request->file('file')->getClientOriginalName();
                $path = $request->file('file')->move(public_path('files'), $filename);
                $validate['file'] = 'files/' . $filename;
            }
            $validate['user_id'] = auth()->user()->id;
            Dokumen::create($validate);
            DB::commit();
            return redirect()->route('dokumen.index')->with('success', 'Dokumen Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dokumen.create')->with('error', 'Dokumen Gagal Ditambahkan');
        }
    }

    public function show(Dokumen $dokumen)
    {
        return view('pages.dokumen.show', compact('dokumen'));
    }

    public function edit(Dokumen $dokumen)
    {
        return view('pages.dokumen.form', compact('dokumen'));
    }
    public function update(Request $request, Dokumen $dokumen)
    {
        $validate = $request->validate([
            'kategori' => 'required|string',
            'tanggal' => 'required|string',
            'judul' => 'required|string',
            'keterangan' => 'required|string',
            'file' => 'nullable|file',
        ]);
        DB::beginTransaction();
        try {
            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($dokumen->file && file_exists(public_path($dokumen->file))) {
                    unlink(public_path($dokumen->file));
                }

                // Simpan file baru
                $filename = time() . '_' . $request->file('file')->getClientOriginalName();
                $request->file('file')->move(public_path('files'), $filename);
                $validate['file'] = 'files/' . $filename;
            } else {
                // Tetap gunakan file lama
                $validate['file'] = $dokumen->file;
            }
            $dokumen->update($validate);
            DB::commit();
            return redirect()->route('dokumen.index')->with('success', 'Dokumen Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dokumen.index')->with('error', 'Dokumen Gagal Diupdate');
        }
    }

    public function destroy(Dokumen $dokumen)
    {
        DB::beginTransaction();
        try {
            $dokumen->delete();
            DB::commit();
            return redirect()->route('dokumen.index')->with('success', 'Dokumen Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dokumen.index')->with('error', 'Dokumen Gagal Diupdate');
        }
    }

    public function datatable()
    {
        $query =  Dokumen::query();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('user', function ($data) {
                return $data->user->name;
            })->addColumn('action', function ($data) {
                return view('components.datatable.action', [
                    'file'   => $data->file,
                    'urlEdit'   => route('dokumen.edit', $data->id),
                    'urlDelete' => route('dokumen.destroy', $data->id),
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
