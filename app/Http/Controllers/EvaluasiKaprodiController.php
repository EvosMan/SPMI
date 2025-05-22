<?php

namespace App\Http\Controllers;

use App\Models\Evaluasi;
use App\Models\HasilEvaluasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluasiKaprodiController extends Controller
{
    public function edit(Evaluasi $kaprodiEvaluasi)
    {
        return view('pages.evaluasi.kaprodiForm', compact('kaprodiEvaluasi'));
    }

    public function update(Request $request, Evaluasi $kaprodiEvaluasi)
    {
        // $validate = $request->validate([
        //     'aspek' => 'required|string',
        //     'tahun' => 'required|string',
        // ]);
        DB::beginTransaction();
        try { // Ambil semua input
            $inputs = $request->all();

            // Loop semua key yang mengandung "jawaban-"
            foreach ($inputs as $key => $value) {
                if (str_starts_with($key, 'jawaban-')) {
                    // Ambil ID dari key, misal dari "jawaban-5" jadi 5
                    $id = str_replace('jawaban-', '', $key);

                    // Ambil data lain berdasarkan ID ini
                    $jawaban = $value;
                    $dokumen = $request->input("dokumen-$id");
                    $keterangan = $request->input("keterangan-$id");

                    // Simpan ke DB
                    HasilEvaluasi::create([
                        'detail_evaluasi_id' => $id, // simpan ID-nya juga kalau perlu
                        'user_id' => auth()->user()->id,
                        'jawaban' => $jawaban,
                        'nama_dokumen' => $dokumen,
                        'keterangan' => $keterangan,
                    ]);
                }
            }
            // $kaprodiEvaluasi->update($validate);
            DB::commit();
            return redirect()->route('evaluasi.index')->with('success', 'Evaluasi Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kaprodi-evaluasi.edit', $kaprodiEvaluasi->id)->with('error', 'Evaluasi Gagal Diupdate');
        }
    }
}
