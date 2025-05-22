<div class="d-flex justify-content-center">
    @if (isset($urlStruk))
        <a href="{{ $urlStruk }}" class="btn btn-warning btn-sm mx-1" target="_blank">Struk</a>
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
</div>
