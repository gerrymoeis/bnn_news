<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();

        if ($adminRole) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@bnn.news',
                'password' => Hash::make('password'), // Ganti password ini nanti
                'role_id' => $adminRole->id,
                'status' => 'active',
            ]);
        }
    }
}
