@extends('layouts.mahasiswa')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Pengguna')

@section('content')

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff3e8; color:#F07B1D;">
                <i class="bi bi-tools"></i>
            </div>
            <div>
                <div class="stat-label">Total Alat Tersedia</div>
                <div class="stat-value">{{ $totalTersedia }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#dcfce7; color:#16a34a;">
                <i class="bi bi-cart-check-fill"></i>
            </div>
            <div>
                <div class="stat-label">Sedang Dipinjam</div>
                <div class="stat-value">{{ $totalDipinjamUser }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fee2e2; color:#ef4444;">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div>
                <div class="stat-label">Stok Habis</div>
                <div class="stat-value">{{ $totalHabis }}</div>
            </div>
        </div>
    </div>
</div>

{{-- DAFTAR ALAT --}}
<div class="card-spsa">
    <div class="card-header-spsa">
        <h5><i class="bi bi-grid-3x3-gap-fill me-2" style="color:var(--orange)"></i> Daftar Alat</h5>
        <a href="{{ route('mahasiswa.keranjang') }}" class="badge-keranjang">
             <i class="bi bi-cart-check-fill"></i> Keranjang
            @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
            @if($cartCount > 0)
                <span class="ms-1">({{ $cartCount }})</span>
            @endif
        </a>
    </div>

    <div class="table-responsive">
        <table class="table-spsa">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Alat</th>
                    <th>Stok</th>
                    <th>Sisa Stok</th>
                    <th>Dipinjam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alat as $index => $item)
                    @php
                        $sisaStok = $item->stok - $item->dipinjam;
                        $tersedia = $sisaStok > 0;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><div style="font-weight:600;">{{ $item->nama_alat }}</div></td>
                        <td>{{ $item->stok }}</td>
                        <td>
                            <span style="font-weight:700;" @if($tersedia) class="text-success" @else class="text-danger" @endif>
                                {{ $sisaStok }}
                            </span>
                        </td>
                        <td>{{ $item->dipinjam }}</td>
                        <td>
                            @if($tersedia)
                                <form action="{{ route('mahasiswa.keranjang.tambah') }}" method="POST" style="display:flex; align-items:center; gap:6px;">
                                    @csrf
                                    <input type="hidden" name="alat_id" value="{{ $item->id }}">
                                    <input type="number" name="jumlah" value="1" min="1" max="{{ $sisaStok }}"
                                           style="width:60px; border:1.5px solid #e2e8f0; border-radius:6px; padding:5px 8px; font-size:13px; font-family:inherit; text-align:center; outline:none;"
                                           onfocus="this.style.borderColor='#22c55e'" onblur="this.style.borderColor='#e2e8f0'">
                                    <button type="submit" class="badge-pinjam">
                                        <i class="bi bi-cart-plus-fill"></i> Pinjam
                                    </button>
                                </form>
                            @else
                                <span class="badge-habis">Habis</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; color:var(--muted); padding:40px;">
                            <i class="bi bi-inbox" style="font-size:32px; display:block; margin-bottom:8px;"></i>
                            Belum ada alat tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection