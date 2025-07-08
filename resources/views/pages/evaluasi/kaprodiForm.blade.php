@extends('layouts.app')
@section('breadcrumb')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $kaprodiEvaluasi->id ? 'Form Evaluasi' : 'Tambah Evaluasi' }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('evaluasi.index') }}">Evaluasi</a></li>
                    <li class="breadcrumb-item active">{{ $kaprodiEvaluasi->id ? 'Form Evaluasi' : 'Tambah Evaluasi' }}
                    </li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form
                    action="{{ $kaprodiEvaluasi->id ? route('kaprodi-evaluasi.update', $kaprodiEvaluasi->id) : route('evaluasi.store') }}"
                    method="post">
                    @csrf
                    @if ($kaprodiEvaluasi->id)
                    @method('PUT')
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Aspek</th>
                                    <th>Ya</th>
                                    <th>Tidak</th>
                                    <th>Nama Dokumen</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kaprodiEvaluasi->detailEvaluasi as $key => $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->sub_aspek }} </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="jawaban-{{ $value->id }}" value="Ya"
                                                {{ optional($value->hasilEvaluasi)->jawaban == 'Ya' ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                Ya
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="jawaban-{{ $value->id }}" value="Tidak"
                                                {{ optional($value->hasilEvaluasi)->jawaban == 'Tidak' ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                Tidak
                                            </label>
                                        </div>
                                    </td>
                                    <td><input type="text" class="form-control"
                                            name="dokumen-{{ $value->id }}"
                                            value="{{ optional($value->hasilEvaluasi)->nama_dokumen ?? '' }}"></td>
                                    <td><input type="text" class="form-control"
                                            name="keterangan-{{ $value->id }}"
                                            value="{{ optional($value->hasilEvaluasi)->keterangan ?? '' }}"></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('evaluasi.index') }}" class="btn btn-secondary">Kembali</a>
                    <button class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection