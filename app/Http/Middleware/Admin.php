<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil peran berdasarkan email pengguna
        $peran = User::peranDariEmail($request->user()->email);

        // Hanya Admin yang diperbolehkan
        if (strtolower((string) $peran) !== 'admin') {
            abort(403, 'Halaman ini hanya dapat diakses oleh Admin.');
        }

        return $next($request);
    }
}
