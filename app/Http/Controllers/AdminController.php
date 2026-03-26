<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalAlat      = Alat::count();
        $totalMenunggu  = Peminjaman::where('status', 'menunggu')->count();
        $totalDisetujui = Peminjaman::where('status', 'disetujui')->count();
        $peminjaman     = Peminjaman::with(['mahasiswa', 'details.alat'])->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalAlat', 'totalMenunggu', 'totalDisetujui', 'peminjaman'
        ));
    }

    /* ── ALAT ── */
    public function alatIndex()
    {
        $alat = Alat::all();
        return view('admin.alat.index', compact('alat'));
    }

    public function alatStore(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'stok'      => 'required|integer|min:1',
        ]);

        Alat::create([
            'nama_alat' => $request->nama_alat,
            'stok'      => $request->stok,
            'dipinjam'  => 0,
        ]);

        return back()->with('success', 'Alat berhasil ditambahkan!');
    }

    public function alatUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'stok'      => 'required|integer|min:1',
        ]);

        $alat = Alat::findOrFail($id);
        $alat->update([
            'nama_alat' => $request->nama_alat,
            'stok'      => $request->stok,
        ]);

        return back()->with('success', 'Alat berhasil diperbarui!');
    }

    public function alatDestroy($id)
    {
        Alat::findOrFail($id)->delete();
        return back()->with('success', 'Alat berhasil dihapus!');
    }

    /* ── PEMINJAMAN ── */
    public function peminjamanIndex()
    {
        $peminjaman = Peminjaman::with(['mahasiswa', 'details.alat'])->latest()->get();
        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function peminjamanSetujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'disetujui']);
        return back()->with('success', 'Peminjaman berhasil disetujui!');
    }

    public function peminjamanTolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Kembalikan stok
        foreach ($peminjaman->details as $detail) {
            Alat::where('id', $detail->alat_id)->decrement('dipinjam', $detail->jumlah);
        }

        $peminjaman->update(['status' => 'ditolak']);
        return back()->with('success', 'Peminjaman ditolak.');
    }

    public function peminjamanKembalikan(Request $request, $id)
    {
        $request->validate([
            'denda' => 'required|integer|min:0',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        // Kembalikan stok
        foreach ($peminjaman->details as $detail) {
            Alat::where('id', $detail->alat_id)->decrement('dipinjam', $detail->jumlah);
        }

        $peminjaman->update([
            'status' => 'dikembalikan',
            'denda'  => $request->denda,
        ]);

        $msg = 'Alat berhasil dikembalikan.';
        if ($request->denda > 0) {
            $msg .= ' Denda: Rp ' . number_format($request->denda, 0, ',', '.');
        }

        return back()->with('success', $msg);
    }

    /* ── LAPORAN ── */
    public function cetakLaporan(Request $request)
    {
        $query = Peminjaman::with(['mahasiswa', 'details.alat']);

        if ($request->dari) {
            $query->whereDate('tanggal_pinjam', '>=', $request->dari);
        }
        if ($request->sampai) {
            $query->whereDate('tanggal_pinjam', '<=', $request->sampai);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $peminjaman        = $query->latest()->get();
        $total             = $peminjaman->count();
        $totalMenunggu     = $peminjaman->where('status', 'menunggu')->count();
        $totalDisetujui    = $peminjaman->where('status', 'disetujui')->count();
        $totalDikembalikan = $peminjaman->where('status', 'dikembalikan')->count();
        $totalDenda        = $peminjaman->sum('denda');

        $dari   = $request->dari;
        $sampai = $request->sampai;
        $status = $request->status;

        return view('admin.laporan.cetak', compact(
            'peminjaman', 'total', 'totalMenunggu',
            'totalDisetujui', 'totalDikembalikan', 'totalDenda',
            'dari', 'sampai', 'status'
        ));
    }

    /* ── MAHASISWA ── */
    public function mahasiswaIndex()
    {
        $mahasiswa = Mahasiswa::all();
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function mahasiswaStore(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
        ]);

        Mahasiswa::create([
            'nama'    => $request->nama,
            'jurusan' => $request->jurusan,
        ]);

        return back()->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    public function mahasiswaUpdate(Request $request, $id)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
        ]);

        Mahasiswa::findOrFail($id)->update([
            'nama'    => $request->nama,
            'jurusan' => $request->jurusan,
        ]);

        return back()->with('success', 'Data mahasiswa berhasil diperbarui!');
    }

    public function mahasiswaDestroy($id)
    {
        Mahasiswa::findOrFail($id)->delete();
        return back()->with('success', 'Mahasiswa berhasil dihapus!');
    }
}