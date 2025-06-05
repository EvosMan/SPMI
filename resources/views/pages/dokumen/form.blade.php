@extends('layouts.app')
@section('breadcrumb')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $dokumen->id ? 'Edit Dokumen' : 'Tambah Dokumen' }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dokumen.index') }}">Manajemen Dokumen</a></li>
                        <li class="breadcrumb-item active">{{ $dokumen->id ? 'Edit Dokumen' : 'Tambah Dokumen' }}</li>
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
                    <form action="{{ $dokumen->id ? route('dokumen.update', $dokumen->id) : route('dokumen.store') }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @if ($dokumen->id)
                            @method('PUT')
                        @endif
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select class="form-control" name="kategori" id="kategori" {{ request('type') ? 'disabled' : '' }}>
                                <option value="">Pilih Kategori</option>
                                <option value="Kebijakan"
                                    {{ (request('type') == 'kebijakan' || $dokumen->kategori == 'Kebijakan' || old('kategori') == 'Kebijakan') ? 'selected' : '' }}>
                                    Kebijakan
                                </option>
                                <option value="Standart"
                                    {{ (request('type') == 'standart' || $dokumen->kategori == 'Standart' || old('kategori') == 'Standart') ? 'selected' : '' }}>
                                    Standart
                                </option>
                                <option value="Manual"
                                    {{ (request('type') == 'manual' || $dokumen->kategori == 'Manual' || old('kategori') == 'Manual') ? 'selected' : '' }}>
                                    Manual
                                </option>
                                <option value="Formulir"
                                    {{ (request('type') == 'formulir' || $dokumen->kategori == 'Formulir' || old('kategori') == 'Formulir') ? 'selected' : '' }}>
                                    Formulir
                                </option>
                            </select>
                            @if(request('type'))
                                <input type="hidden" name="kategori" value="{{ ucfirst(request('type')) }}">
                            @endif
                            @error('kategori')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
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
                            <label for="revisi">Revisi</label>
                            <input type="text" name="revisi" id="revisi"
                                class="form-control @error('revisi') is-invalid @enderror"
                                value
                                ="{{ old('revisi') ?? $dokumen->revisi }}">
                            @error('revisi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan">{{ old('keterangan') ?? $dokumen->keterangan }}</textarea>
                            @error('keterangan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" name="file" id="file"
                                class="form-control-file @error('file') is-invalid @enderror"
                                value="{{ old('file') ?? $dokumen->file }}">
                            @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <a href="{{ route('dokumen.index') }}" class="btn btn-secondary">Kembali</a>
                        <button class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
