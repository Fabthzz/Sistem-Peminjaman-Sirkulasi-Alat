<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $alat = Alat::all();

        $totalTersedia = $alat->filter(fn($i) => ($i->stok - $i->dipinjam) > 0)->count();
        $totalHabis    = $alat->filter(fn($i) => ($i->stok - $i->dipinjam) <= 0)->count();

        $totalDipinjamUser = Peminjaman::where('user_id', Auth::id())
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->count();

        return view('mahasiswa.dashboard', compact(
            'alat',
            'totalTersedia',
            'totalHabis',
            'totalDipinjamUser'
        ));
    }

    public function keranjang()
    {
        $cart = session('cart', []);
        return view('mahasiswa.keranjang', compact('cart'));
    }

    public function tambahKeranjang(Request $request)
    {
        $request->validate([
            'alat_id' => 'required|exists:alat,id',
            'jumlah'  => 'required|integer|min:1',
        ]);

        $alat     = Alat::findOrFail($request->alat_id);
        $sisaStok = max(0, $alat->stok - $alat->dipinjam);

        if ($sisaStok <= 0) {
            return back()->with('error', 'Stok alat sudah habis!');
        }

        if ($request->jumlah > $sisaStok) {
            return back()->with('error', "Jumlah melebihi sisa stok ($sisaStok tersedia)!");
        }

        $cart = session('cart', []);

        foreach ($cart as $key => $item) {
            if ($item['alat_id'] == $request->alat_id) {
                $totalJumlah = $item['jumlah'] + $request->jumlah;

                if ($totalJumlah > $sisaStok) {
                    return back()->with('error', "Total jumlah melebihi sisa stok ($sisaStok tersedia)!");
                }

                $cart[$key]['jumlah'] = $totalJumlah;
                session(['cart' => $cart]);

                return back()->with('success', $alat->nama_alat . ' diperbarui (total: ' . $totalJumlah . ')');
            }
        }

        $cart[] = [
            'alat_id'   => $alat->id,
            'nama_alat' => $alat->nama_alat,
            'jumlah'    => $request->jumlah,
        ];

        session(['cart' => $cart]);

        return back()->with('success', $alat->nama_alat . ' berhasil ditambahkan!');
    }

    public function hapusKeranjang(Request $request)
    {
        $request->validate(['alat_id' => 'required']);

        $cart = session('cart', []);
        $cart = array_values(array_filter($cart, fn($item) => $item['alat_id'] != $request->alat_id));

        session(['cart' => $cart]);

        return back()->with('success', 'Alat dihapus dari keranjang.');
    }

    public function submitPinjam(Request $request)
    {
        $request->validate([
            'tanggal_pinjam'   => 'required|date|after_or_equal:today',
            'tanggal_kembali'  => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong!');
        }

        $peminjaman = Peminjaman::create([
            'user_id'          => Auth::id(), // 🔥 FIX DI SINI
            'tanggal_pinjam'   => $request->tanggal_pinjam,
            'tanggal_kembali'  => $request->tanggal_kembali,
            'status'           => 'menunggu',
            'denda'            => 0,
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
            ->with('success', 'Peminjaman berhasil diajukan!');
    }

    public function riwayat()
    {
        $peminjaman = Peminjaman::with(['details.alat'])
            ->where('user_id', Auth::id()) // 🔥 FIX DI SINI
            ->latest()
            ->get();

        return view('mahasiswa.riwayat', compact('peminjaman'));
    }
}