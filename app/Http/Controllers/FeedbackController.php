<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('pages.feedback.index');
    }
    public function create(Request $request)
    {
        return view('pages.feedback.form', [
            'feedback' => new Feedback(),
        ]);
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'kategori' => 'required|string',
            'keterangan' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            if ($request->hasFile('file')) {
                $filename = time() . '_' . $request->file('file')->getClientOriginalName();
                $path = $request->file('file')->move(public_path('files'), $filename);
                $validate['file'] = 'files/' . $filename;
            }
            $validate['user_id'] = auth()->user()->id;
            Feedback::create($validate);
            DB::commit();
            return redirect()->route('dokumen.index')->with('success', 'Dokumen Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dokumen.create')->with('error', 'Dokumen Gagal Ditambahkan');
        }
    }

    public function show(Feedback $feedback)
    {
        return view('pages.feedback.show', compact('feedback'));
    }

    public function edit(Feedback $feedback)
    {
        return view('pages.feedback.form', compact('feedback'));
    }
    public function update(Request $request, Feedback $feedback)
    {
        $validate = $request->validate([
            'kategori' => 'required|string',
            'tanggal' => 'required|string',
            'judul' => 'required|string',
            'revisi' => 'required|string',
            'keterangan' => 'required|string',
            'file' => 'nullable|file',
        ]);
        DB::beginTransaction();
        try {
            $feedback->update($validate);
            DB::commit();
            return redirect()->route('dokumen.index')->with('success', 'Dokumen Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dokumen.index')->with('error', 'Dokumen Gagal Diupdate');
        }
    }

    public function destroy(Feedback $feedback)
    {
        DB::beginTransaction();
        try {
            $feedback->delete();
            DB::commit();
            return redirect()->route('dokumen.index')->with('success', 'Dokumen Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dokumen.index')->with('error', 'Dokumen Gagal Diupdate');
        }
    }

    public function datatable()
    {
        $query =  Feedback::query()->orderBy('created_at', 'desc');
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('user', function ($data) {
                return $data->user->name;
            })
            ->addColumn('evaluasi', function ($data) {
                return '-';
            })
            ->addColumn('action', function ($data) {
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
