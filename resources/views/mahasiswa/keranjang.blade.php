@extends('layouts.mahasiswa')

@section('title', 'Keranjang')
@section('page-title', 'Keranjang Peminjaman')

@section('content')

<div class="card-spsa">
    <div class="card-header-spsa">
        <h5><i class="bi bi-archive-fill me-2" style="color:var(--orange)"></i> Keranjang Peminjaman</h5>
        <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-sm btn-outline-secondary" style="font-size:13px; border-radius:8px;">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @if(empty($cart))
        <div style="text-align:center; padding:60px; color:var(--muted);">
            <i class="bi bi-cart-x-fill" style="font-size:48px; display:block; margin-bottom:12px; color:#ddd;"></i>
            <div style="font-weight:600; font-size:15px; margin-bottom:6px;">Keranjang Kosong</div>
            <div style="font-size:13px;">Silakan pilih alat yang ingin dipinjam dari Dashboard.</div>
            <a href="{{ route('mahasiswa.dashboard') }}" class="badge-pinjam mt-3" style="display:inline-flex;">
                <i class="bi bi-arrow-left"></i> Ke Dashboard
            </a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table-spsa">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Alat</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td style="font-weight:600;">{{ $item['nama_alat'] }}</td>
                            <td>{{ $item['jumlah'] }}</td>
                            <td>
                                <form action="{{ route('mahasiswa.keranjang.hapus') }}" method="POST" style="display:inline">
                                    @csrf
                                    <input type="hidden" name="alat_id" value="{{ $item['alat_id'] }}">
                                    <button type="submit" style="background:#fee2e2; color:#ef4444; border:none; padding:5px 12px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; font-family:inherit;">
                                        <i class="bi bi-trash3"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- FORM SUBMIT PEMINJAMAN --}}
        <div style="padding:20px 22px; border-top:1px solid #f0f2f5;">
            <form action="{{ route('mahasiswa.pinjam.submit') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label style="font-size:13px; font-weight:600; display:block; margin-bottom:6px;">
                            Tanggal Pinjam
                        </label>
                        <input type="date" name="tanggal_pinjam" class="form-control" required
                               value="{{ date('Y-m-d') }}"
                               style="border-radius:8px; font-size:14px;">
                    </div>
                    <div class="col-md-5">
                        <label style="font-size:13px; font-weight:600; display:block; margin-bottom:6px;">
                            Tanggal Kembali
                        </label>
                        <input type="date" name="tanggal_kembali" class="form-control" required
                               style="border-radius:8px; font-size:14px;">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="badge-keranjang w-100"
                                style="padding:10px 14px; border-radius:8px; font-size:13px; justify-content:center;">
                            <i class="bi bi-send-check-fill"></i> Ajukan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>

@endsection