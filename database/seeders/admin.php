<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class admin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new Client();
        $admin->name = 'admin';
        $admin->email = 'admin@gmail.com';
        $admin->password =Hash::make( 'adminadmin');
        $admin->phone='8715854676';
        $admin->role= 1;
        $admin->active=1;
        
        $admin->save();
    }
}
