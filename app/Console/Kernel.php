<?php

namespace App\Console;


use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\AddUserCommand::class,
        \App\Console\Commands\CreateAssignmentsCommand::class,
        \App\Console\Commands\SendAssignmentsCommand::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Ejemplo: enviar emails todos los días a las 9:00
        // $schedule->command('assignments:send')->dailyAt('09:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
