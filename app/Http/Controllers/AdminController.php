<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalAlat      = Alat::count();
        $totalMenunggu  = Peminjaman::where('status', 'menunggu')->count();
        $totalDisetujui = Peminjaman::where('status', 'disetujui')->count();

        $peminjaman = Peminjaman::with(['user', 'details.alat'])
            ->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalAlat',
            'totalMenunggu',
            'totalDisetujui',
            'peminjaman'
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
            'stok' => 'required|integer|min:0'
        ]);

        $alat = Alat::findOrFail($id);

        if ($request->stok < $alat->dipinjam) {
            return back()->with('error', 'Stok tidak boleh lebih kecil dari yang sedang dipinjam!');
        }

        $alat->update([
            'stok' => $request->stok
        ]);

        return back()->with('success', 'Stok berhasil diupdate');
    }

    public function alatDestroy($id)
    {
        Alat::findOrFail($id)->delete();
        return back()->with('success', 'Alat berhasil dihapus!');
    }

    /* ── PEMINJAMAN ── */
    public function peminjamanIndex()
    {
        $peminjaman = Peminjaman::with(['user', 'details.alat'])
            ->latest()->paginate(10);

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function peminjamanSetujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'disetujui']);

        return back()->with('success', 'Peminjaman disetujui!');
    }

    public function peminjamanTolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        foreach ($peminjaman->details as $detail) {
            Alat::where('id', $detail->alat_id)
                ->decrement('dipinjam', $detail->jumlah);
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

        foreach ($peminjaman->details as $detail) {
            Alat::where('id', $detail->alat_id)
                ->decrement('dipinjam', $detail->jumlah);
        }

        $peminjaman->update([
            'status' => 'dikembalikan',
            'denda'  => $request->denda,
        ]);

        return back()->with('success', 'Pengembalian berhasil.');
    }

    /* ── LAPORAN ── */
    public function cetakLaporan(Request $request)
    {
        $query = \App\Models\Peminjaman::with(['user', 'details.alat']);

        // 🔍 FILTER TANGGAL
        if ($request->dari) {
            $query->whereDate('tanggal_pinjam', '>=', $request->dari);
        }

        if ($request->sampai) {
            $query->whereDate('tanggal_pinjam', '<=', $request->sampai);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->latest()->get();

        $total = $peminjaman->count();
        $totalMenunggu = $peminjaman->where('status', 'menunggu')->count();
        $totalDisetujui = $peminjaman->where('status', 'disetujui')->count();
        $totalDikembalikan = $peminjaman->where('status', 'dikembalikan')->count();
        $totalDenda = $peminjaman->sum('denda');

        return view('admin.laporan.cetak', [
            'peminjaman' => $peminjaman,

            // 🔥 INI BIAR GA ERROR
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'status' => $request->status,

            // 🔥 SUMMARY
            'total' => $total,
            'totalMenunggu' => $totalMenunggu,
            'totalDisetujui' => $totalDisetujui,
            'totalDikembalikan' => $totalDikembalikan,
            'totalDenda' => $totalDenda,
        ]);
    }

    /* ── USER (ADMIN) ── */
    public function adminIndex(Request $request)
    {
        $query = \App\Models\User::where('role', 'admin');

        // 🔍 SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }

        $admins = $query->latest()->paginate(10);
        $admins->appends($request->all());

        return view('admin.admin.index', compact('admins'));
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:users,nim',
            'password' => 'required|min:6',
        ]);

        User::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return back()->with('success', 'Admin berhasil ditambahkan');
    }

    public function adminDestroy($id)
    {
        User::destroy($id);
        return back()->with('success', 'Admin dihapus');
    }

    /* ── USER (MAHASISWA) ── */
    public function mahasiswaIndex(Request $request)
    {
        $query = \App\Models\User::where('role', 'mahasiswa');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }

        $mahasiswa = $query->latest()->paginate(10);

        $mahasiswa->appends($request->all());

        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function mahasiswaStore(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'nim'      => 'required|digits_between:10,15|unique:users,nim',
            'password' => 'required|min:6',
        ]);

        User::create([
            'nama'     => $request->nama,
            'nim'      => $request->nim,
            'password' => bcrypt($request->password),
            'role'     => 'mahasiswa',
        ]);

        return back()->with('success', 'User berhasil ditambahkan!');
    }

    public function mahasiswaUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $user->update([
            'nama' => $request->nama,
        ]);

        return back()->with('success', 'User diperbarui!');
    }

    public function mahasiswaDestroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User dihapus!');
    }
}
