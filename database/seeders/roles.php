<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class roles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    
    {
        Rol::create([
            'name' => 'admin',
        ]);
        Rol::create([
            'name' => 'user',
        ]);
        Rol::create([
            'name' => 'empleado',
        ]);
    }
}
