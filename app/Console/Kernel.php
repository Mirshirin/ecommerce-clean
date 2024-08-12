<?php

namespace App\Console;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            try {
                $deletedCount = Product::where('price', '>', 1000)->delete();
                Log::info("Deleted {$deletedCount} products with price > 1000.");
            } catch (\Exception $e) {
                Log::error("Failed to delete products: " . $e->getMessage());
            }
        })->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
