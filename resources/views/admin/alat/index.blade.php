@extends('layouts.admin')

@section('title', 'Kelola Alat')
@section('page-title', 'Kelola Alat')

@section('content')

<div class="card-spsa">
    <div class="card-header-spsa">
        <h5><i class="bi bi-tools me-2" style="color:var(--orange)"></i> Daftar Alat</h5>
        <button onclick="document.getElementById('modalTambah').style.display='flex'"
                style="background:var(--orange); color:white; border:none; padding:8px 16px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; font-family:inherit; display:flex; align-items:center; gap:6px;">
            <i class="bi bi-plus-lg"></i> Tambah Alat
        </button>
    </div>

    <div class="table-responsive">
        <table class="table-spsa">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Alat</th>
                    <th>Stok Total</th>
                    <th>Sisa Stok</th>
                    <th>Dipinjam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alat as $index => $item)
                    @php
                        $sisaStok = $item->stok - $item->dipinjam;
                        $dipinjam = $item->dipinjam;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td style="font-weight:600;">{{ $item->nama_alat }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>
                            <span style="font-weight:700;" @if($sisaStok > 0) class="text-success" @else class="text-danger" @endif>
                                {{ $sisaStok }}
                            </span>
                        </td>
                        <td>{{ $dipinjam }}</td>
                        <td>
                            <div style="display:flex; gap:6px;">
                                {{-- Edit Button --}}
                                <button class="btn-edit-alat"
                                        data-id="{{ $item->id }}"
                                        data-nama="{{ $item->nama_alat }}"
                                        data-stok="{{ $item->stok }}"
                                        style="background:#fef9c3; color:#854d0e; border:none; padding:5px 12px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; font-family:inherit;">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                {{-- Delete --}}
                                <form action="{{ route('admin.alat.destroy', $item->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus alat ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            style="background:#fee2e2; color:#991b1b; border:none; padding:5px 12px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; font-family:inherit;">
                                        <i class="bi bi-trash3"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:40px; color:var(--muted);">
                            <i class="bi bi-inbox" style="font-size:32px; display:block; margin-bottom:8px;"></i>
                            Belum ada data alat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div id="modalTambah" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:200; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:14px; padding:28px; width:100%; max-width:420px; margin:20px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
            <h6 style="font-weight:700; font-size:16px; margin:0;">Tambah Alat Baru</h6>
            <button onclick="document.getElementById('modalTambah').style.display='none'"
                    style="background:none; border:none; font-size:20px; cursor:pointer; color:#aaa;">&times;</button>
        </div>
        <form action="{{ route('admin.alat.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:16px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Nama Alat</label>
                <input type="text" name="nama_alat" class="form-control" required placeholder="Contoh: Mouse, Keyboard..."
                       style="border-radius:8px; font-size:14px;">
            </div>
            <div style="margin-bottom:20px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Stok</label>
                <input type="number" name="stok" class="form-control" required min="1" placeholder="Jumlah stok"
                       style="border-radius:8px; font-size:14px;">
            </div>
            <button type="submit"
                    style="width:100%; background:var(--orange); color:white; border:none; padding:11px; border-radius:8px; font-size:14px; font-weight:700; cursor:pointer; font-family:inherit;">
                <i class="bi bi-plus-lg"></i> Simpan Alat
            </button>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modalEdit" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:200; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:14px; padding:28px; width:100%; max-width:420px; margin:20px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
            <h6 style="font-weight:700; font-size:16px; margin:0;">Edit Alat</h6>
            <button onclick="document.getElementById('modalEdit').style.display='none'"
                    style="background:none; border:none; font-size:20px; cursor:pointer; color:#aaa;">&times;</button>
        </div>
        <form id="formEdit" method="POST">
            @csrf @method('PUT')
            <div style="margin-bottom:16px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Nama Alat</label>
                <input type="text" id="editNama" name="nama_alat" class="form-control" required
                       style="border-radius:8px; font-size:14px;">
            </div>
            <div style="margin-bottom:20px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Stok</label>
                <input type="number" id="editStok" name="stok" class="form-control" required min="1"
                       style="border-radius:8px; font-size:14px;">
            </div>
            <button type="submit"
                    style="width:100%; background:var(--orange); color:white; border:none; padding:11px; border-radius:8px; font-size:14px; font-weight:700; cursor:pointer; font-family:inherit;">
                <i class="bi bi-check-lg"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Tombol edit pakai data-attribute, bukan onclick langsung
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-edit-alat').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id   = this.dataset.id;
            var nama = this.dataset.nama;
            var stok = this.dataset.stok;

            document.getElementById('editNama').value  = nama;
            document.getElementById('editStok').value  = stok;
            document.getElementById('formEdit').action = '/admin/alat/' + id;
            document.getElementById('modalEdit').style.display = 'flex';
        });
    });
});
</script>
@endpush