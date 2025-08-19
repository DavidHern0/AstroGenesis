<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('npc:construct')->everyMinute();       // Cada minuto
        // $schedule->command('npc:construct')->everyFiveMinutes();  // Cada 5 minutos
        // $schedule->command('npc:construct')->everyTenMinutes();   // Cada 10 minutos
        // $schedule->command('npc:construct')->everyFifteenMinutes(); // Cada 15 minutos
        // $schedule->command('npc:construct')->everyThirtyMinutes(); // Cada 30 minutos
        // $schedule->command('npc:construct')->hourly();           // Cada hora
        // $schedule->command('npc:construct')->hourlyAt(15);       // Cada hora, en minuto 15
        // $schedule->command('npc:construct')->daily();            // Todos los días a medianoche
        // $schedule->command('npc:construct')->dailyAt('13:00');   // Todos los días a la 1pm
        // $schedule->command('npc:construct')->twiceDaily(1, 13);  // Dos veces al día: 1am y 1pm
        // $schedule->command('npc:construct')->weekly();           // Cada semana (domingo 0:00)
        // $schedule->command('npc:construct')->monthly();          // Cada mes (día 1 a medianoche)
        // $schedule->command('npc:construct')->yearly();           // Cada año (1 enero 0:00)
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
