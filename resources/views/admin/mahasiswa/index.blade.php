@extends('layouts.admin')

@section('title', 'Data Mahasiswa')
@section('page-title', 'Data Mahasiswa')

@section('content')

<div class="card-spsa">
    <div class="card-header-spsa">
        <h5><i class="bi bi-people-fill me-2" style="color:var(--orange)"></i> Daftar Mahasiswa</h5>
        <button onclick="document.getElementById('modalTambah').style.display='flex'"
            style="background:var(--orange); color:white; border:none; padding:8px 16px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; font-family:inherit; display:flex; align-items:center; gap:6px;">
            <i class="bi bi-plus-lg"></i> Tambah Mahasiswa
        </button>
    </div>

    <div class="table-responsive">
        <table class="table-spsa">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mahasiswa as $index => $mhs)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-weight:600;">{{ $mhs->nama }}</td>
                    <td>
                        <span style="background:#fff3e8; color:#F07B1D; padding:3px 10px; border-radius:5px; font-size:12px; font-weight:600;">
                            {{ $mhs->jurusan }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <button class="btn-edit-mhs"
                                data-id="{{ $mhs->id }}"
                                data-nama="{{ $mhs->nama }}"
                                data-jurusan="{{ $mhs->jurusan }}"
                                style="background:#fef9c3; color:#854d0e; border:none; padding:5px 12px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; font-family:inherit;">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <form action="{{ route('admin.mahasiswa.destroy', $mhs->id) }}" method="POST"
                                onsubmit="return confirm('Hapus mahasiswa ini?')">
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
                    <td colspan="4" style="text-align:center; padding:50px; color:var(--muted);">
                        <i class="bi bi-people" style="font-size:32px; display:block; margin-bottom:8px;"></i>
                        Belum ada data mahasiswa.
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
            <h6 style="font-weight:700; font-size:16px; margin:0;">Tambah Mahasiswa</h6>
            <button onclick="document.getElementById('modalTambah').style.display='none'"
                style="background:none; border:none; font-size:20px; cursor:pointer; color:#aaa;">&times;</button>
        </div>
        <form action="{{ route('admin.mahasiswa.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:16px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required placeholder="Nama lengkap mahasiswa"
                    style="border-radius:8px; font-size:14px;">
            </div>
            <div style="margin-bottom:20px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Jurusan</label>
                <input type="text" name="jurusan" class="form-control" required placeholder="Contoh: Ilmu Komputer"
                    style="border-radius:8px; font-size:14px;">
            </div>
            <button type="submit"
                style="width:100%; background:var(--orange); color:white; border:none; padding:11px; border-radius:8px; font-size:14px; font-weight:700; cursor:pointer; font-family:inherit;">
                <i class="bi bi-plus-lg"></i> Simpan Mahasiswa
            </button>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modalEdit" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:200; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:14px; padding:28px; width:100%; max-width:420px; margin:20px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
            <h6 style="font-weight:700; font-size:16px; margin:0;">Edit Mahasiswa</h6>
            <button onclick="document.getElementById('modalEdit').style.display='none'"
                style="background:none; border:none; font-size:20px; cursor:pointer; color:#aaa;">&times;</button>
        </div>
        <form id="formEdit" method="POST">
            @csrf @method('PUT')
            <div style="margin-bottom:16px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Nama Lengkap</label>
                <input type="text" id="editNama" name="nama" class="form-control" required
                    style="border-radius:8px; font-size:14px;">
            </div>
            <div style="margin-bottom:20px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Jurusan</label>
                <input type="text" id="editJurusan" name="jurusan" class="form-control" required
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
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-edit-mhs').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.getElementById('editNama').value = this.dataset.nama;
                document.getElementById('editJurusan').value = this.dataset.jurusan;
                document.getElementById('formEdit').action = '/admin/mahasiswa/' + this.dataset.id;
                document.getElementById('modalEdit').style.display = 'flex';
            });
        });
    });
</script>
@endpush