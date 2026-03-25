<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ── LOGIN PAGE ──
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        if (session('mahasiswa_id')) {
            return redirect()->route('mahasiswa.dashboard');
        }

        $jurusanList = Mahasiswa::select('jurusan')->distinct()->pluck('jurusan');

        return view('auth.login', compact('jurusanList'));
    }

    // ── ADMIN LOGIN ──
    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    // ── MAHASISWA LOGIN ──
    public function loginMahasiswa(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string',
            'jurusan' => 'required|string',
        ]);

         $mahasiswa = Mahasiswa::firstOrCreate([
            'nama'    => $request->nama,
            'jurusan' => $request->jurusan,
        ]);

        // Simpan ke session
        session([
            'mahasiswa_id'      => $mahasiswa->id,  
            'mahasiswa_nama'    => $mahasiswa->nama,
            'mahasiswa_jurusan' => $mahasiswa->jurusan,
        ]);

        return redirect()->route('mahasiswa.dashboard');
    }

    // ── LOGOUT ──
    public function logout(Request $request)
    {
        // Logout admin
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
        }

        // Logout mahasiswa
        if (session('mahasiswa_id')) {
            $request->session()->forget(['mahasiswa_id', 'mahasiswa_nama', 'mahasiswa_jurusan', 'cart']);
            return redirect()->route('login');
        }

        return redirect()->route('login');
    }
}