@extends('layouts.admin')

@section('title', 'Persetujuan Alat')
@section('page-title', 'Persetujuan Peminjaman')

@section('content')

<div class="card-spsa">
    <div class="card-header-spsa">
        <h5><i class="bi bi-card-checklist me-2" style="color:var(--orange)"></i> Daftar Persetujuan Peminjaman</h5>
    </div>

    <div class="table-responsive">
        <table class="table-spsa">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>Jurusan</th>
                    <th>Alat Dipinjam</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-weight:600;">{{ $item->mahasiswa->nama ?? '-' }}</td>
                    <td>
                        <span style="background:#f0f2f5; padding:2px 8px; border-radius:4px; font-size:12px;">
                            {{ $item->mahasiswa->jurusan ?? '-' }}
                        </span>
                    </td>
                    <td>
                        @foreach($item->details as $detail)
                        <span style="display:inline-block; background:#fff3e8; color:#F07B1D; padding:2px 8px; border-radius:4px; font-size:12px; margin:2px; font-weight:600;">
                            {{ $detail->alat->nama_alat ?? '-' }}
                        </span>
                        @endforeach
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</td>
                    <td>
                        @if($item->status == 'menunggu')
                        <span style="background:#fef9c3; color:#854d0e; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:600;">
                            <i class="bi bi-hourglass-split"></i> Menunggu
                        </span>
                        @elseif($item->status == 'disetujui')
                        <span style="background:#dcfce7; color:#166534; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:600;">
                            <i class="bi bi-check-circle-fill"></i> Disetujui
                        </span>
                        @elseif($item->status == 'dikembalikan')
                        <span style="background:#e0f2fe; color:#0369a1; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:600;">
                            <i class="bi bi-arrow-return-left"></i> Dikembalikan
                        </span>
                        @else
                        <span style="background:#fee2e2; color:#991b1b; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:600;">
                            <i class="bi bi-x-circle-fill"></i> Ditolak
                        </span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:6px; flex-wrap:wrap;">
                            @if($item->status == 'menunggu')
                            <form action="{{ route('admin.peminjaman.setujui', $item->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    style="background:#dcfce7; color:#166534; border:none; padding:5px 12px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; font-family:inherit;">
                                    <i class="bi bi-check-lg"></i> Setujui
                                </button>
                            </form>
                            <form action="{{ route('admin.peminjaman.tolak', $item->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    style="background:#fee2e2; color:#991b1b; border:none; padding:5px 12px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; font-family:inherit;">
                                    <i class="bi bi-x-lg"></i> Tolak
                                </button>
                            </form>
                            @elseif($item->status == 'disetujui')
                            <button class="btn-kembalikan"
                                data-id="{{ $item->id }}"
                                data-nama="{{ $item->mahasiswa->nama ?? '' }}"
                                data-tgl="{{ $item->tanggal_kembali }}"
                                style="background:#e0f2fe; color:#0369a1; border:none; padding:5px 12px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; font-family:inherit;">
                                <i class="bi bi-arrow-return-left"></i> Kembalikan
                            </button>
                            @else
                            <span style="color:#aaa; font-size:12px;">-</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:50px; color:var(--muted);">
                        <i class="bi bi-inbox" style="font-size:32px; display:block; margin-bottom:8px;"></i>
                        Belum ada data peminjaman.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
{{-- MODAL KEMBALIKAN --}}
<div id="modalKembalikan" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:200; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:14px; padding:28px; width:100%; max-width:420px; margin:20px; box-shadow:0 20px 60px rgba(0,0,0,0.2);">

        {{-- Header --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:36px; height:36px; background:#e0f2fe; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#0369a1;">
                    <i class="bi bi-arrow-return-left"></i>
                </div>
                <h6 style="font-weight:700; font-size:15px; margin:0;">Konfirmasi Pengembalian</h6>
            </div>
            <button onclick="closeModal()" style="background:none; border:none; font-size:20px; cursor:pointer; color:#aaa; line-height:1;">&times;</button>
        </div>

        {{-- Info mahasiswa --}}
        <div style="background:#f8fafc; border-radius:10px; padding:14px; margin-bottom:20px;">
            <div style="font-size:12px; color:#6c757d; margin-bottom:4px;">Mahasiswa</div>
            <div id="modalNamaMhs" style="font-weight:700; font-size:15px;"></div>
            <div style="font-size:12px; color:#6c757d; margin-top:8px;">Tanggal Kembali Seharusnya</div>
            <div id="modalTglKembali" style="font-weight:600; font-size:13px;"></div>
        </div>

        {{-- Status keterlambatan --}}
        <div id="infoTerlambat" style="display:none; background:#fee2e2; border-radius:10px; padding:12px 14px; margin-bottom:16px;">
            <div style="color:#991b1b; font-size:13px; font-weight:600; display:flex; align-items:center; gap:6px;">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span id="textTerlambat"></span>
            </div>
        </div>
        <div id="infoTepat" style="display:none; background:#dcfce7; border-radius:10px; padding:12px 14px; margin-bottom:16px;">
            <div style="color:#166534; font-size:13px; font-weight:600; display:flex; align-items:center; gap:6px;">
                <i class="bi bi-check-circle-fill"></i> Dikembalikan tepat waktu — tidak ada denda.
            </div>
        </div>

        {{-- Form denda --}}
        <form id="formKembalikan" method="POST">
            @csrf @method('PATCH')
            <div style="margin-bottom:20px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:6px;">
                    Nominal Denda (Rp)
                    <span style="color:#6c757d; font-weight:400; font-size:12px;">— bisa diubah manual</span>
                </label>
                <div style="position:relative;">
                    <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:13px; font-weight:600; color:#6c757d;">Rp</span>
                    <input type="number" id="inputDenda" name="denda" min="0" step="1000" value="0"
                        style="width:100%; border:1.5px solid #e2e8f0; border-radius:10px; padding:11px 14px 11px 38px; font-size:15px; font-weight:600; font-family:inherit; outline:none; transition:border-color .2s;"
                        onfocus="this.style.borderColor='#0369a1'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                <div style="font-size:12px; color:#6c757d; margin-top:5px;">
                    Nominal otomatis dihitung dari keterlambatan. Edit jika perlu.
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                <button type="button" onclick="closeModal()"
                    style="background:#f1f5f9; color:#475569; border:none; padding:11px; border-radius:10px; font-size:14px; font-weight:600; font-family:inherit; cursor:pointer;">
                    Batal
                </button>
                <button type="submit"
                    style="background:#0369a1; color:white; border:none; padding:11px; border-radius:10px; font-size:14px; font-weight:600; font-family:inherit; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="bi bi-check-lg"></i> Konfirmasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const DENDA_PER_HARI = 5000;

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-kembalikan').forEach(function(btn) {
            btn.addEventListener('click', function() {
                openModalKembalikan(this.dataset.id, this.dataset.nama, this.dataset.tgl);
            });
        });
    });

    function openModalKembalikan(id, nama, tglKembali) {
        document.getElementById('modalNamaMhs').textContent = nama;

        const tgl = new Date(tglKembali);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        tgl.setHours(0, 0, 0, 0);

        const selisihHari = Math.floor((today - tgl) / (1000 * 60 * 60 * 24));

        document.getElementById('modalTglKembali').textContent =
            tgl.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

        let dendaOtomatis = 0;
        if (selisihHari > 0) {
            dendaOtomatis = selisihHari * DENDA_PER_HARI;
            document.getElementById('infoTerlambat').style.display = 'block';
            document.getElementById('infoTepat').style.display = 'none';
            document.getElementById('textTerlambat').textContent =
                `Terlambat ${selisihHari} hari — denda otomatis Rp ${dendaOtomatis.toLocaleString('id-ID')}`;
        } else {
            document.getElementById('infoTerlambat').style.display = 'none';
            document.getElementById('infoTepat').style.display = 'block';
        }

        document.getElementById('inputDenda').value = dendaOtomatis;
        document.getElementById('formKembalikan').action = `/admin/peminjaman/${id}/kembalikan`;
        document.getElementById('modalKembalikan').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('modalKembalikan').style.display = 'none';
    }

    document.getElementById('modalKembalikan').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endpush