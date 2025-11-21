<?php

namespace App\Console\Commands;

use App\Http\Services\AssignmentService;
use Illuminate\Console\Command;

class SendAssignmentsCommand extends Command
{
    protected $signature = 'assignments:send {giver?} {year?}';
    protected $description = 'Envía emails con la asignación. Opcional: {giver} por nombre y {year}';

    public function handle()
    {
        $giver = $this->argument('giver');
        $year = $this->argument('year') ? intval($this->argument('year')) : null;

        try {
            $sent = (new AssignmentService())->sendEmails($giver, $year);
            $this->info("Emails enviados: {$sent}");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        return 0;
    }
}
