<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class DokumenController extends Controller
{
    public function index($type)
    {
        return view("pages.dokumen.{$type}.index", compact('type'));
    }

    public function create($type)
    {
        $dokumen = new Dokumen();
        return view("pages.dokumen.{$type}.form", compact('dokumen', 'type'));
    }

    public function store(Request $request, $type)
    {
        $validate = $request->validate([
            'tanggal' => 'required|string',
            'judul' => 'required|string',
            'keterangan' => 'required|string',
            'file' => 'required|file',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('file')) {
                $filename = time() . '_' . $request->file('file')->getClientOriginalName();
                $request->file('file')->move(public_path('files'), $filename);
                $validate['file'] = 'files/' . $filename;
            }

            $validate['kategori'] = ucfirst($type);
            $validate['user_id'] = auth()->id();

            Dokumen::create($validate);
            DB::commit();

            // Ubah cara redirect
            return redirect("dokumen/{$type}")->with('success', 'Dokumen Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return redirect()->back()->withInput()->with('error', 'Dokumen Gagal Ditambahkan: ' . $th->getMessage());
        }
    }

    public function show(Dokumen $dokumen)
    {
        return view('pages.dokumen.show', compact('dokumen'));
    }

    public function edit($type, Dokumen $dokumen)
    {
        return view("pages.dokumen.{$type}.form", compact('dokumen', 'type'));
    }

    public function update(Request $request, $type, Dokumen $dokumen)
    {
        $validate = $request->validate([
            'tanggal' => 'required|string',
            'judul' => 'required|string',
            'keterangan' => 'required|string',
            'file' => 'nullable|file', // Make file optional during update
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('file')) {
                // Delete old file if exists
                if ($dokumen->file && file_exists(public_path($dokumen->file))) {
                    unlink(public_path($dokumen->file));
                }

                // Save new file
                $filename = time() . '_' . $request->file('file')->getClientOriginalName();
                $request->file('file')->move(public_path('files'), $filename);
                $validate['file'] = 'files/' . $filename;
            } else {
                // Keep existing file
                unset($validate['file']); // Remove file from validation if not uploaded
            }

            $validate['kategori'] = ucfirst($type);
            $dokumen->update($validate);
            DB::commit();

            return redirect()->route('dokumen.type.index', ['type' => $type])
                ->with('success', 'Dokumen Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Dokumen Gagal Diupdate: ' . $th->getMessage());
        }
    }

    public function destroy($type, Dokumen $dokumen)
    {
        DB::beginTransaction();
        try {
            // Check if file exists and delete it
            if ($dokumen->file && file_exists(public_path($dokumen->file))) {
                unlink(public_path($dokumen->file));
            }
            
            // Delete the document record
            $dokumen->delete();
            DB::commit();

            return redirect("dokumen/{$type}")
                ->with('success', 'Dokumen Berhasil Dihapus');

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error deleting document: ' . $th->getMessage());
            
            return redirect("dokumen/{$type}")
                ->with('error', 'Dokumen Gagal Dihapus: ' . $th->getMessage());
        }
    }

    public function datatable(Request $request)
    {
        $query = Dokumen::query()->with('user');

        if ($request->type) {
            $query->where('kategori', ucfirst($request->type));
        }

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) use ($request) {
                $btn = '<div class="btn-group">';
                // Ubah URL untuk preview PDF langsung di browser
                $btn .= '<a href="/' . ($row->file) . '" class="btn btn-sm btn-success" target="_blank" data-toggle="tooltip" title="Preview"><i class="fas fa-download"></i></a> ';
                $btn .= '<a href="' . route('dokumen.type.edit', [$request->type, $row->id]) . '" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a> ';
                $btn .= '<form action="' . route('dokumen.type.destroy', [$request->type, $row->id]) . '" method="POST" class="d-inline">';
                $btn .= csrf_field() . method_field('DELETE');
                $btn .= '<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah anda yakin?\')" data-toggle="tooltip" title="Hapus"><i class="fas fa-trash"></i></button>';
                $btn .= '</form>';
                $btn .= '</div>';
                return $btn;
            })
            ->editColumn('tanggal', function ($row) {
                return $row->tanggal ? date('d/m/Y', strtotime($row->tanggal)) : '';
            })
            ->editColumn('user', function ($row) {
                return $row->user ? $row->user->name : '';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
