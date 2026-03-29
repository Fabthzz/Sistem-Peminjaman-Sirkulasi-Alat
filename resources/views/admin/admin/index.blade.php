@extends('layouts.admin')

@section('title', 'Data Admin')
@section('page-title', 'Data Admin')

@section('content')

<div class="card-spsa">
    <div class="card-header-spsa">
        <h5>
            <i class="bi bi-shield-lock-fill me-2" style="color:var(--orange)"></i>
            Daftar Admin
        </h5>

        <div style="display:flex; gap:10px; align-items:center;">

            {{-- SEARCH --}}
            <form method="GET" action="{{ route('admin.list') }}" style="display:flex;">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama / NIM..."
                    style="padding:6px 10px; border-radius:6px; border:1px solid #ddd; font-size:13px;">

                <button type="submit"
                    style="margin-left:6px; background:#e2e8f0; border:none; padding:6px 10px; border-radius:6px; cursor:pointer;">
                    🔍
                </button>
            </form>

            {{-- BUTTON TAMBAH --}}
            <button onclick="document.getElementById('modalTambah').style.display='flex'"
                style="background:var(--orange); color:white; border:none; padding:8px 16px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:6px;">
                <i class="bi bi-plus-lg"></i> Tambah
            </button>

        </div>
    </div>

    <table class="table-spsa">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($admins as $i => $a)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $a->nama }}</td>
                <td>{{ $a->nim }}</td>
                <td>
                    <form action="{{ route('admin.destroy', $a->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit"
                            style="background:#fee2e2; color:#991b1b; border:none; padding:5px 12px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer;">
                            <i class="bi bi-trash3"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center;">Belum ada admin</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- MODAL --}}
<div id="modalTambah" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:200; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:14px; padding:28px; width:100%; max-width:420px;">

        <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
            <h6>Tambah Admin</h6>
            <button onclick="document.getElementById('modalTambah').style.display='none'">&times;</button>
        </div>

        <form action="{{ route('admin.store') }}" method="POST">
            @csrf

            <div style="margin-bottom:12px;">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div style="margin-bottom:12px;">
                <label>NIM</label>
                <input type="text" name="nim" class="form-control" required>
            </div>

            <div style="margin-bottom:20px;">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit"
                style="width:100%; background:var(--orange); color:white; padding:10px; border:none; border-radius:8px;">
                Simpan
            </button>
        </form>

    </div>
</div>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('editNama').value = this.dataset.nama;
            document.getElementById('editNim').value = this.dataset.nim;
            document.getElementById('formEdit').action = '/admin/admin/' + this.dataset.id;
            document.getElementById('modalEdit').style.display = 'flex';
        });
    });
</script>
@endpush