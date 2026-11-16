<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Manajer
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()->adalahManajer()) {
            abort(403, 'Halaman ini hanya untuk Manajer.');
        }

        return $next($request);
    }
}

