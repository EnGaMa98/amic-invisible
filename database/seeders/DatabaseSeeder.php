<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Participant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $group = Group::create([
            'name' => 'Nadal 2025',
            'description' => 'Amic invisible de Nadal',
            'budget' => 20.00,
            'event_date' => '2025-12-25',
            'status' => 'draft',
        ]);

        $names = ['Anna', 'Marc', 'Laura', 'Jordi', 'Maria'];

        foreach ($names as $name) {
            Participant::create([
                'group_id' => $group->id,
                'name' => $name,
                'email' => strtolower($name) . '@example.com',
            ]);
        }
    }
}
