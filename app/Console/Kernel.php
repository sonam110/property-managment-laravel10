<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */

    protected $commands = [
        Commands\GenerateInvoice::class,
        Commands\SendInvoice::class,
        Commands\LeasePriceUpdate::class,
        Commands\LeaseExpiryMail::class,
        
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:generate-invoice')
            ->monthlyOn(25, '00:00')
            ->timezone(env('TIME_ZONE', 'Asia/Calcutta'));

        $schedule->command('app:send-invoice')
            ->monthlyOn(28, '09:00')
            ->timezone(env('TIME_ZONE', 'Asia/Calcutta'));
            
        $schedule->command('app:lease-expiry-mail')
            ->dailyAt('12:00 AM')
            ->timezone(env('TIME_ZONE', 'Asia/Calcutta'));

        $schedule->command('app:lease-price-update')
            ->dailyAt('12:15 AM')
            ->timezone(env('TIME_ZONE', 'Asia/Calcutta'));

        
    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
