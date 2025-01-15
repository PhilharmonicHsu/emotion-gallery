<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

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
        if ($googleCredentials = env('GOOGLE_APPLICATION_CREDENTIALS_JSON')) {
            $tempPath = storage_path('app/google-service-key.json');
            File::put($tempPath, base64_decode($googleCredentials));

            // 设置 Google Cloud SDK 环境变量
            putenv("GOOGLE_APPLICATION_CREDENTIALS=$tempPath");
        }

        // 檢查連接是否為 pgsql，然後設置正確的 client_encoding
        if (config('database.default') === 'pgsql') {
            DB::statement("SET client_encoding TO 'UTF8';");
        }
    }
}
