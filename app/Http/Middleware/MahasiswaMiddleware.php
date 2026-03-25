<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MahasiswaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('mahasiswa_id')) {
            return redirect()->route('login')->withErrors(['nama' => 'Silakan login terlebih dahulu.']);
        }

        return $next($request);
    }
}