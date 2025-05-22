@extends('layouts.app')
@section('breadcrumb')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $evaluasi->id ? 'Edit Evaluasi' : 'Tambah Evaluasi' }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('evaluasi.index') }}">Manajemen Evaluasi</a></li>
                        <li class="breadcrumb-item active">{{ $evaluasi->id ? 'Edit Evaluasi' : 'Tambah Evaluasi' }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ $evaluasi->id ? route('evaluasi.update', $evaluasi->id) : route('evaluasi.store') }}"
                        method="post">
                        @csrf
                        @if ($evaluasi->id)
                            @method('PUT')
                        @endif
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <select class="form-control" name="tahun" id="tahun">
                                <option value="">Pilih tahun</option>
                                @for ($i = 2010; $i < date('Y'); $i++)
                                    <option value="{{ $i }}"
                                        {{ $evaluasi->tahun == $i || old('tahun') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('tahun')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="aspek">Aspek</label>
                            <input type="text" name="aspek" id="aspek"
                                class="form-control @error('aspek') is-invalid @enderror"
                                value="{{ old('aspek') ?? $evaluasi->aspek }}">
                            @error('aspek')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
