<?php

namespace App\Providers;

use App\Models\Hotel;
use Carbon\Carbon;
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
        // Chỉ chạy ở môi trường local
        if (app()->environment('local')) {
            $today = Carbon::today();

            // Lấy các khách sạn cần mở lại
            $hotelsToOpen = Hotel::where('h_isclose', 1)
                ->where('h_dateopen', '<=', $today)
                ->get();

            foreach ($hotelsToOpen as $hotel) {
                $hotel->update([
                    'h_isclose' => 0,
                    'h_dateclose' => null,
                    'h_dateopen' => null,
                ]);
            }
        }
    }
}
