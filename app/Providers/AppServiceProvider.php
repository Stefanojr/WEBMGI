<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Hash;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Hash::extend('bcrypt', function () {
            return new BcryptHasher();
        });

        // Paksa Laravel menggunakan Bcrypt
        Hash::driver('bcrypt');
    }
}
