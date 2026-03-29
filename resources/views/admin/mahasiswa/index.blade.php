@extends('layouts.admin')

@section('title', 'Data Mahasiswa')
@section('page-title', 'Data Mahasiswa')

@section('content')

<div class="card-spsa">
    <div class="card-header-spsa">
        <h5>
            <i class="bi bi-people-fill me-2" style="color:var(--orange)"></i>
            Daftar Mahasiswa
        </h5>

        <div style="display:flex; gap:10px; align-items:center;">

            {{-- SEARCH --}}
            <form method="GET" action="{{ route('admin.mahasiswa.index') }}" style="display:flex;">
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

    <div class="table-responsive">
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
                @forelse($mahasiswa as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-weight:600;">{{ $item->nama }}</td>
                    <td>{{ $item->nim }}</td>

                    <td>
                        <div style="display:flex; gap:6px;">

                            {{-- EDIT --}}
                            <button class="btn-edit"
                                data-id="{{ $item->id }}"
                                data-nama="{{ $item->nama }}"
                                data-nim="{{ $item->nim }}"
                                style="background:#fef9c3; color:#854d0e; border:none; padding:5px 12px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer;">
                                <i class="bi bi-pencil"></i> Edit
                            </button>

                            {{-- DELETE --}}
                            <form action="{{ route('admin.mahasiswa.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Hapus mahasiswa ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    style="background:#fee2e2; color:#991b1b; border:none; padding:5px 12px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer;">
                                    <i class="bi bi-trash3"></i> Hapus
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:40px;">
                        Belum ada data mahasiswa.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top:20px; display:flex; justify-content:center;">
            {{ $mahasiswa->links() }}
        </div>
    </div>
</div>


{{-- MODAL TAMBAH --}}
<div id="modalTambah" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:200; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:14px; padding:28px; width:100%; max-width:420px;">

        <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
            <h6>Tambah Mahasiswa</h6>
            <button onclick="document.getElementById('modalTambah').style.display='none'">&times;</button>
        </div>

        <form action="{{ route('admin.mahasiswa.store') }}" method="POST">
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


{{-- MODAL EDIT --}}
<div id="modalEdit" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:200; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:14px; padding:28px; width:100%; max-width:420px;">

        <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
            <h6>Edit Mahasiswa</h6>
            <button onclick="document.getElementById('modalEdit').style.display='none'">&times;</button>
        </div>

        <form id="formEdit" method="POST">
            @csrf @method('PUT')

            <div style="margin-bottom:12px;">
                <label>Nama</label>
                <input type="text" id="editNama" name="nama" class="form-control" required>
            </div>

            <div style="margin-bottom:20px;">
                <label>NIM</label>
                <input type="text" id="editNim" name="nim" class="form-control" required>
            </div>

            <button type="submit"
                style="width:100%; background:var(--orange); color:white; padding:10px; border:none; border-radius:8px;">
                Update
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
            document.getElementById('formEdit').action = '/admin/mahasiswa/' + this.dataset.id;
            document.getElementById('modalEdit').style.display = 'flex';
        });
    });
</script>
@endpush