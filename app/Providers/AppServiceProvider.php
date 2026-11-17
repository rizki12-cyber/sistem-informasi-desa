<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        
        if (app()->environment('production') && rand(1, 100) === 1) {
            try {
                DB::table('complaint_lookup_logs')
                    ->where('created_at', '<', now()->subDays(30))
                    ->delete();
            } catch (\Exception $e) {
            }
        }
    }
}