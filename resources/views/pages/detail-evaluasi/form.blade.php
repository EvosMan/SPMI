@extends('layouts.app')
@section('breadcrumb')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $evaluasi->id ? 'Edit Sub Aspek' : 'Tambah Sub Aspek' }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('detailEvaluasi.index', $evaluasi->id) }}">Detail
                                Evaluasi</a></li>
                        <li class="breadcrumb-item active">{{ $evaluasi->id ? 'Edit Sub Aspek' : 'Tambah Sub Aspek' }}</li>
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
                    <form
                        action="{{ $detail->id ? route('detailEvaluasi.update', [$evaluasi->id, $detail->id]) : route('detailEvaluasi.store', $evaluasi->id) }}"
                        method="post">
                        @csrf
                        @if ($detail->id)
                            @method('PUT')
                        @endif
                        <input type="hidden" name="evaluasi_id" value="{{ $evaluasi->id }}">
                        <div class="form-group">
                            <label for="sub_aspek">Sub Aspek</label>
                            <input type="text" name="sub_aspek" id="sub_aspek"
                                class="form-control @error('sub_aspek') is-invalid @enderror"
                                value="{{ old('sub_aspek') ?? $detail->sub_aspek }}">
                            @error('sub_aspek')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <a href="{{ route('detailEvaluasi.index', $evaluasi->id) }}" class="btn btn-secondary">Kembali</a>
                        <button class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
