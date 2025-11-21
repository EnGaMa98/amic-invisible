<?php

namespace App\Console\Commands;

use App\Http\Services\AssignmentService;
use Illuminate\Console\Command;

class CreateAssignmentsCommand extends Command
{
    protected $signature = 'assignments:generate {year?}';
    protected $description = 'Genera les assignacions';

    public function handle()
    {
        $year = $this->argument('year') ? intval($this->argument('year')) : intval(date('Y'));

        try {
            $count = (new AssignmentService())->generateAssignments($year);
            $this->info("Asignacions generades: {$count} per l'any {$year}");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        return 0;
    }
}
