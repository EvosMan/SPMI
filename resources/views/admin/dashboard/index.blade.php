@php
    use Carbon\Carbon;
@endphp
@extends('layouts.app')
@section('breadcrumb')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection
@section('content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        {{-- <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>0</h3>

                    <p>Total Audit</p>
                </div>
            </div>
        </div> --}}
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $countDokumen ?? 0 }}</h3>
                    <p>Jumlah Dokumen</p>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <!-- Main row -->
    {{-- <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">

            <!-- LINE CHART -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Jadwal Audit</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Tahun/Bulan</td>
                                <td>Pendapatan</td>
                                <td>Beban</td>
                                <td>Laba</td>
                                <td>Rugi</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($report as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->month_year }}</td>
                                    <td>Rp. {{ number_format((int) $item->total_pemasukan ?? 0, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format((int) $item->total_pengeluaran ?? 0, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format((int) $item->untung ?? 0, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format((int) $item->rugi ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div> --}}
    <!-- /.row (main row) -->
@endsection
@push('sub-styles')
    <link rel="stylesheet" href="/theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endpush
@push('sub-scripts')
    <script src="/theme/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/theme/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script>
        $('.table-bordered').DataTable();
    </script>
@endpush
