<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class admin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new Client();
        $admin->name = 'admin';
        $admin->email = 'admin123@gmail.ocm';
        $admin->password = '12345678';
        $admin->phone='8717453045';
        
        $admin->role= 1;
        $admin->active=1;
        
        $admin->save();
    }
}
