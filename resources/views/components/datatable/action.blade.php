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
        <form action="{{ $urlValidasi }}" method="post">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-success btn-sm mx-1"
                onclick="return confirm('Apakah anda yakin ingin memvalidasi data ini?')">Validasi</button>
        </form>
    @endif
    @if (isset($urlPelaksanaan))
        <form action="{{ $urlPelaksanaan }}" method="post">
            @csrf
            @method('PUT')
            <input type="submit" class="btn btn-success btn-sm mx-1" value="Sudah Dilaksanakan"
                name="status_pelaksanaan"
                onclick="return confirm('Apakah anda yakin ingin memvalidasi pelaksanaan audit ini?')">
            <input type="submit" class="btn btn-danger btn-sm mx-1" value="Belum Dilaksanakan"
                name="status_pelaksanaan"
                onclick="return confirm('Apakah anda yakin ingin memvalidasi pelaksanaan audit ini?')">
        </form>
    @endif
</div>
