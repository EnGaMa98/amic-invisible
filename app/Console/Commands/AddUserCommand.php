<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Services\UserService;
use Illuminate\Validation\ValidationException;

class AddUserCommand extends Command
{
    protected $signature = 'user:add {name} {email}';
    protected $description = 'Afegir un usuari amb nom i email';

    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');

        try {
            $user = (new UserService())->create([
                'name' => $name,
                'email' => $email,
            ]);
            $this->info("Usuario creado: {$user->id} - {$user->name} <{$user->email}>");
        } catch (ValidationException $e) {
            foreach ($e->errors() as $field => $messages) {
                foreach ($messages as $msg) {
                    $this->error($msg);
                }
            }
            return 1;
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        return 0;
    }
}
