@extends('layouts.app')
@section('breadcrumb')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Pemasukan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pemasukan.index') }}">Pemasukan</a></li>
                        <li class="breadcrumb-item active">Detail Pemasukan</li>
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
                    <div class="form-group">
                        <label for="tgl_beban">Tanggal Beban</label>
                        <input type="date" name="tgl_beban" id="tgl_beban" class="form-control"
                            value="{{ old('tgl_beban') ?? $pemasukan->tgl_beban }}">
                    </div>
                    <div class="form-group">
                        <label for="nama_beban">Nama Beban</label>
                        <input type="text" name="nama_beban" id="nama_beban" class="form-control"
                            value="{{ old('nama_beban') ?? $pemasukan->nama_beban }}">
                    </div>
                    <div class="form-group">
                        <label for="akun_id">Akun</label>
                        <input type="text" name="akun_id" id="akun_id" class="form-control"
                            value="{{ $pemasukan->akun->id }} - {{ $pemasukan->akun->nama }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="total">total</label>
                        <input type="text" name="total" id="total" class="form-control"
                            value="{{ $pemasukan->total }}">
                    </div>
                    <a href="{{ route('pemasukan.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
