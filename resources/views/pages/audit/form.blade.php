@extends('layouts.app')
@section('breadcrumb')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $audit->id ? 'Edit Hasil Audit' : 'Tambah Hasil Audit' }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('audit.index') }}">Audit</a></li>
                        <li class="breadcrumb-item active">{{ $audit->id ? 'Edit Audit' : 'Tambah Audit' }}</li>
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
                    <form action="{{ $audit->id ? route('audit.update', $audit->id) : route('audit.store') }}"
                        method="post">
                        @csrf
                        @if ($audit->id)
                            @method('PUT')
                        @endif
                        <div class="form-group">
                            <label for="jadwal_audit_id">Pilih Jadwal Audit</label>
                            <select class="form-control" name="jadwal_audit_id" id="jadwal_audit_id">
                                <option value="">Pilih Jadwal Audit</option>
                                @foreach ($jadwal as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $audit->jadwal_audit_id == $item->id || old('jadwal_audit_id') == $item->id ? 'selected' : '' }}>
                                        Audit Tahun {{ $item->tahun }} ({{ $item->tanggal_mulai }} -
                                        {{ $item->tanggal_selesai }})
                                    </option>
                                @endforeach
                                @for ($i = 2010; $i < date('Y'); $i++)
                                @endfor
                            </select>
                            @error('jadwal_audit_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="Keterangan">Feedback</label>
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan">{{ old('keterangan') ?? $audit->keterangan }}</textarea>
                            @error('Keterangan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="">Pilih Status Audit</option>
                                <option value="Tercapai"
                                    {{ $audit->status == 'Tercapai' || old('status') == 'Tercapai' ? 'selected' : '' }}>
                                    Tercapai
                                </option>
                                <option value="Belum Tercapai"
                                    {{ $audit->status == 'Belum Tercapai' || old('status') == 'Belum Tercapai' ? 'selected' : '' }}>
                                    Belum Tercapai
                                </option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <a href="{{ route('audit.index') }}" class="btn btn-secondary">Kembali</a>
                        <button class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
