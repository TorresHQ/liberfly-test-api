<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\ServiceProvider;

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
        response()->macro('ok', function (mixed $data) {
            return response()->json($data, 200);
        });

        response()->macro('unauthorized', function (string $message = 'Unauthenticated.') {
            return response()->json(['message' => $message], 401);
        });

        response()->macro('notFound', function (string $message = 'Not Found.') {
            return response()->json(['message' => $message], 404);
        });
    }
}
