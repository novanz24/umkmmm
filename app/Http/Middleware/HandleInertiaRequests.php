<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * Blade view root untuk Inertia.
     * Pastikan ada resources/views/app.blade.php
     */
    protected $rootView = 'app';
    
    /**
     * Versi aset untuk cache-busting (biarkan default).
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Data yang dishare ke semua halaman Inertia.
     * DI SINI tempat function share(), JANGAN di file lain.
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user()
                    ? $request->user()->only('id','name','email','role')
                    : null,
                'orders_count' => fn () => $request->user()
                ? $request->user()->orders()->count()
                : 0,
           
            ],
            'flash' => [
                'ok' => fn () => $request->session()->get('ok'),
            ],
            'csrf_token' => csrf_token(),
        ]);
    }
    
}
