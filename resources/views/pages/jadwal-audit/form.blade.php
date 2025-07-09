@extends('layouts.app')
@section('breadcrumb')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $audit->id ? 'Edit Jadwal Audit' : 'Tambah Jadwal Audit' }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('jadwalAudit.index') }}">Jadwal Audit</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $audit->id ? 'Edit Jadwal Audit' : 'Tambah Jadwal Audit' }}
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
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ $audit->id ? route('jadwalAudit.update', $audit->id) : route('jadwalAudit.store') }}"
                    method="post">
                    @csrf
                    @if ($audit->id)
                    @method('PUT')
                    @endif
                    <div class="form-group">
                        <label for="kegiatan">Kegiatan</label>
                        <input type="text" name="kegiatan" id="kegiatan"
                            class="form-control @error('kegiatan') is-invalid @enderror"
                            value="{{ old('kegiatan') ?? $audit->kegiatan }}">
                        @error('kegiatan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                            class="form-control @error('tanggal_mulai') is-invalid @enderror"
                            value="{{ old('tanggal_mulai') ?? $audit->tanggal_mulai }}">
                        @error('tanggal_mulai')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal_selesai">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                            class="form-control @error('tanggal_selesai') is-invalid @enderror"
                            value="{{ old('tanggal_selesai') ?? $audit->tanggal_selesai }}">
                        @error('tanggal_selesai')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <textarea name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi">{{ old('lokasi') ?? $audit->lokasi }}</textarea>
                        @error('lokasi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" name="keterangan" id="keterangan"
                            class="form-control @error('keterangan') is-invalid @enderror"
                            value="{{ old('keterangan') ?? $audit->keterangan }}">
                        @error('keterangan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <a href="{{ route('jadwalAudit.index') }}" class="btn btn-secondary">Kembali</a>
                    <button class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection