<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@blog.com')->first();

        if(!$admin){
            User::create([
                'name' => 'Super Admin',
                'email' => 'admin@blog.com',
                'password' => bcrypt('password'),
            ]);
        }
    }
}
