@extends('layouts.app')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manajemen Dokumen {{ ucfirst($type) }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Manajemen Dokumen {{ ucfirst($type) }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tabel Data Dokumen {{ ucfirst($type) }}</h3>
                <a href="{{ route('dokumen.type.create', $type) }}" class="btn btn-primary float-right">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </div>
            <div class="card-body">
                @include('components.app.alert')
                <table class="table table-bordered table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Judul</th>

                            <th>Di Upload Oleh</th>
                            <th>Keterangan</th>
                            <th width="15%">Aksi</th>
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
<link rel="stylesheet" href="/theme/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush

@push('sub-scripts')
<script src="/theme/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/theme/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('dokumen.datatable') }}",
            data: {
                type: "{{ $type }}"
            }
        },
        columnDefs: [{
            targets: '_all',
            className: 'text-center'
        }],
        columns: [{
            data: 'DT_RowIndex',
            searchable: false,
            orderable: false
        }, {
            data: 'tanggal'
        }, {
            data: 'kategori'
        }, {
            data: 'judul'
        }, {
            data: 'user',
            name: 'user.name'
        }, {
            data: 'keterangan'
        }, {
            data: 'action',
            searchable: false,
            orderable: false
        }],
        order: [
            [1, 'desc']
        ] // Sort by tanggal descending
    });
</script>
@endpush