@extends('layouts.app')
@section('breadcrumb')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Aspek {{ $evaluasi->aspek }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manajemen Evaluasi</li>
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
                <div class="card-header">
                    <h3 class="card-title">Tabel Detail Evaluasi</h3>
                    <a href="{{ route('detailEvaluasi.create', $evaluasi->id) }}" class="btn btn-primary float-right">
                        Tambah</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @include('components.app.alert')
                    <table class="table table-bordered" id="datatable">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Sub Aspek</th>
                                <th style="width: 20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('sub-styles')
    <link rel="stylesheet" href="/theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    {{-- <link rel="stylesheet" href="/theme/plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> --}}
@endpush
@push('sub-scripts')
    <script src="/theme/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/theme/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script>
        $('#datatable').DataTable({
            ajax: {
                url: "{{ route('detailEvaluasi.datatable') }}",
                data: {
                    evaluasi_id: "{{ $evaluasi->id }}"
                }
            },
            columnDefs: [{
                targets: '_all',
                className: 'text-center',
            }],
            columns: [{
                data: 'DT_RowIndex'
            }, {
                data: 'sub_aspek'
            }, {
                data: 'action'
            }]
        });
    </script>
@endpush
