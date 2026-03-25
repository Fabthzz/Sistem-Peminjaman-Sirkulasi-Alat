<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $alat = Alat::all();

        $totalTersedia     = $alat->filter(fn($i) => ($i->stok - $i->dipinjam) > 0)->count();
        $totalHabis        = $alat->filter(fn($i) => ($i->stok - $i->dipinjam) <= 0)->count();
        $totalDipinjamUser = Peminjaman::where('mahasiswa_id', session('mahasiswa_id'))
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->count();

        return view('mahasiswa.dashboard', compact('alat', 'totalTersedia', 'totalHabis', 'totalDipinjamUser'));
    }

    public function keranjang()
    {
        $cart = session('cart', []);
        return view('mahasiswa.keranjang', compact('cart'));
    }

    public function tambahKeranjang(Request $request)
    {
        $request->validate(['alat_id' => 'required|exists:alat,id']);

        $alat     = Alat::findOrFail($request->alat_id);
        $sisaStok = max(0, $alat->stok - $alat->dipinjam);

        if ($sisaStok <= 0) {
            return back()->with('error', 'Stok alat sudah habis!');
        }

        $cart = session('cart', []);

        foreach ($cart as $item) {
            if ($item['alat_id'] == $request->alat_id) {
                return back()->with('error', 'Alat sudah ada di keranjang!');
            }
        }

        $cart[] = [
            'alat_id'   => $alat->id,
            'nama_alat' => $alat->nama_alat,
            'jumlah'    => 1,
        ];

        session(['cart' => $cart]);

        return back()->with('success', $alat->nama_alat . ' berhasil ditambahkan ke keranjang!');
    }

    public function hapusKeranjang(Request $request)
    {
        $request->validate(['alat_id' => 'required']);

        $cart = session('cart', []);
        $cart = array_values(array_filter($cart, fn($item) => $item['alat_id'] != $request->alat_id));
        session(['cart' => $cart]);

        return back()->with('success', 'Alat berhasil dihapus dari keranjang.');
    }

    public function submitPinjam(Request $request)
    {
        $request->validate([
            'tanggal_pinjam'  => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong!');
        }

        $peminjaman = Peminjaman::create([
            'mahasiswa_id'    => session('mahasiswa_id'),
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status'          => 'menunggu',
            'denda'           => 0,
        ]);

        foreach ($cart as $item) {
            PeminjamanDetail::create([
                'peminjaman_id' => $peminjaman->id,
                'alat_id'       => $item['alat_id'],
                'jumlah'        => $item['jumlah'],
            ]);

            Alat::where('id', $item['alat_id'])->increment('dipinjam', $item['jumlah']);
        }

        session()->forget('cart');

        return redirect()->route('mahasiswa.riwayat')
            ->with('success', 'Peminjaman berhasil diajukan! Menunggu persetujuan admin.');
    }

    public function riwayat()
    {
        $peminjaman = Peminjaman::with(['details.alat'])
            ->where('mahasiswa_id', session('mahasiswa_id'))
            ->latest()
            ->get();

        return view('mahasiswa.riwayat', compact('peminjaman'));
    }
}