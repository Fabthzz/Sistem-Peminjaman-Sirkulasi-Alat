@extends('layouts.mahasiswa')

@section('title', 'Riwayat')
@section('page-title', 'Riwayat Peminjaman')

@section('content')

<div class="card-spsa">
    <div class="card-header-spsa">
        <h5><i class="bi bi-clock-history me-2" style="color:var(--orange)"></i> Riwayat Peminjaman</h5>
    </div>

    <div class="table-responsive">
        <table class="table-spsa">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Alat</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</td>
                        <td>
                            @foreach($item->details as $detail)
                                <span style="display:inline-block; background:#f0f2f5; padding:2px 8px; border-radius:4px; font-size:12px; margin:2px;">
                                    {{ $detail->alat->nama_alat ?? '-' }}
                                </span>
                            @endforeach
                        </td>
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
                            @elseif($item->status == 'ditolak')
                                <span style="background:#fee2e2; color:#991b1b; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:600;">
                                    <i class="bi bi-x-circle-fill"></i> Ditolak
                                </span>
                            @else
                                <span style="background:#f0f2f5; color:#6c757d; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:600;">
                                    {{ ucfirst($item->status) }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($item->denda && $item->denda > 0)
                                <span style="color:#ef4444; font-weight:700;">
                                    Rp {{ number_format($item->denda, 0, ',', '.') }}
                                </span>
                            @else
                                <span style="color:#aaa;">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; color:var(--muted); padding:50px;">
                            <i class="bi bi-inbox" style="font-size:32px; display:block; margin-bottom:8px;"></i>
                            Belum ada riwayat peminjaman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection