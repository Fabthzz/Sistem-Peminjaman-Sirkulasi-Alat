@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff3e8; color:#F07B1D;"><i class="bi bi-tools"></i></div>
            <div>
                <div class="stat-label">Total Alat</div>
                <div class="stat-value">{{ $totalAlat }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef9c3; color:#854d0e;"><i class="bi bi-hourglass-split"></i></div>
            <div>
                <div class="stat-label">Menunggu Persetujuan</div>
                <div class="stat-value">{{ $totalMenunggu }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#dcfce7; color:#16a34a;"><i class="bi bi-check-circle-fill"></i></div>
            <div>
                <div class="stat-label">Disetujui</div>
                <div class="stat-value">{{ $totalDisetujui }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#ede9fe; color:#7c3aed;"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-label">Total Mahasiswa</div>
                <div class="stat-value">{{ $totalMahasiswa }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card-spsa">
    <div class="card-header-spsa">
        <h5><i class="bi bi-card-checklist me-2" style="color:var(--orange)"></i> Persetujuan Peminjaman Terbaru</h5>
        <a href="{{ route('admin.peminjaman.index') }}"
           style="font-size:13px; color:var(--orange); text-decoration:none; font-weight:600;">
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table class="table-spsa">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>Alat</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td style="font-weight:600;">{{ $item->mahasiswa->nama ?? '-' }}</td>
                        <td>
                            @foreach($item->details as $detail)
                                <span style="display:inline-block; background:#f0f2f5; padding:2px 8px; border-radius:4px; font-size:12px; margin:2px;">
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:40px; color:var(--muted);">
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