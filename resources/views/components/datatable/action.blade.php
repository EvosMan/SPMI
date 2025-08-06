<div class="d-flex justify-content-center">
    @if (isset($urlCetak))
    <a href="{{ $urlCetak }}" class="btn btn-warning btn-sm mx-1" target="_blank">Cetak</a>
    @endif
    @if (isset($file))
    <a href="{{ $file }}" class="btn btn-warning btn-sm mx-1" target="_blank">File</a>
    @endif
    @if (isset($urlShow))
    <a href="{{ $urlShow }}" class="btn btn-success btn-sm mx-1">Detail</a>
    @endif
    @if (isset($urlPilih))
    <a href="{{ $urlPilih }}" class="btn btn-success btn-sm mx-1">Pilih</a>
    @endif
    @if (isset($urlEdit))
    <a href="{{ $urlEdit }}" class="btn btn-primary btn-sm mx-1">Edit</a>
    @endif
    @if (isset($urlDelete))
    <form action="{{ $urlDelete }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm mx-1"
            onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</button>
    </form>
    @endif
    @if (isset($urlValidasi))
    <!-- Tombol Setuju -->
    <form action="{{ $urlValidasi }}" method="post" class="d-inline">
        @csrf
        @method('PUT')
        <input type="hidden" name="action" value="setuju">
        <button type="submit" class="btn btn-success btn-sm mx-1" onclick="return confirm('Setujui audit ini?')">Setuju</button>
    </form>

    <!-- Tombol Reschedule -->
    <button type="button" class="btn btn-warning btn-sm mx-1" data-toggle="modal" data-target="#modal-reschedule-{{ $rowId ?? '' }}">
        Reschedule
    </button>
    <!-- Modal Reschedule -->
    <div class="modal fade" id="modal-reschedule-{{ $rowId ?? '' }}" tabindex="-1" role="dialog" aria-labelledby="modalRescheduleLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ $urlValidasi }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="action" value="reschedule">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRescheduleLabel">Alasan Reschedule</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reason-reschedule-{{ $rowId ?? '' }}">Alasan</label>
                            <textarea class="form-control" name="reason" id="reason-reschedule-{{ $rowId ?? '' }}" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Kirim Reschedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tombol Tolak -->
    <button type="button" class="btn btn-danger btn-sm mx-1" data-toggle="modal" data-target="#modal-tolak-{{ $rowId ?? '' }}">
        Tolak
    </button>
    <!-- Modal Tolak -->
    <div class="modal fade" id="modal-tolak-{{ $rowId ?? '' }}" tabindex="-1" role="dialog" aria-labelledby="modalTolakLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ $urlValidasi }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="action" value="tolak">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTolakLabel">Alasan Penolakan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reason-tolak-{{ $rowId ?? '' }}">Alasan</label>
                            <textarea class="form-control" name="reason" id="reason-tolak-{{ $rowId ?? '' }}" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Kirim Penolakan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    @if (isset($urlPelaksanaan))
    <form action="{{ $urlPelaksanaan }}" method="post">
        @csrf
        @method('PUT')
        <input type="submit" class="btn btn-success btn-sm mx-1" value="Sudah Dilaksanakan"
            name="status_pelaksanaan"
            onclick="return confirm('Apakah anda yakin ingin memvalidasi pelaksanaan audit ini?')">

    </form>
    @endif
</div>