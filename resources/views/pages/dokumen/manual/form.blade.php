@extends('layouts.app')
@section('breadcrumb')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $dokumen->id ? 'Edit' : 'Tambah' }} Dokumen {{ ucfirst($type) }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dokumen.type.index', $type) }}">Manajemen Dokumen {{ ucfirst($type) }}</a></li>
                    <li class="breadcrumb-item active">{{ $dokumen->id ? 'Edit' : 'Tambah' }} Dokumen</li>
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
                <form action="{{ $dokumen->id ? route('dokumen.type.update', [$type, $dokumen->id]) : route('dokumen.type.store', $type) }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @if ($dokumen->id)
                    @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="tanggal">Tanggal Dokumen</label>
                        <input type="date" name="tanggal" id="tanggal"
                            class="form-control @error('tanggal') is-invalid @enderror"
                            value="{{ old('tanggal') ?? $dokumen->tanggal }}">
                        @error('tanggal')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="judul">Judul Dokumen</label>
                        <input type="text" name="judul" id="judul"
                            class="form-control @error('judul') is-invalid @enderror"
                            value="{{ old('judul') ?? $dokumen->judul }}">
                        @error('judul')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                            id="keterangan" rows="3">{{ old('keterangan') ?? $dokumen->keterangan }}</textarea>
                        @error('keterangan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="file">File</label>
                        <input type="file" name="file" id="file"
                            class="form-control-file @error('file') is-invalid @enderror">
                        @if($dokumen->file)
                        <small class="form-text text-muted">File saat ini: {{ basename($dokumen->file) }}</small>
                        @endif
                        @error('file')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <a href="{{ route('dokumen.type.index', $type) }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">
                            {{ $dokumen->id ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection