<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(10)->create();
        $users = [ 
            [
                 
                'name'=>'Admin',
                'email'=>'admin@gmail.com',
                'password' => Hash::make('111'),
                'role'=>'admin', 
            ],
            [
                
                'name'=>'Hemanath',
                'email'=>'appuser@gmail.com',
                'password' => Hash::make('111'),
                'role'=>'user',
            ],
        ]; 

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
