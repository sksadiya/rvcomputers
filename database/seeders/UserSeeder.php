<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create user
    $adminUser = User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'avatar' => 'user-dummy-img.jpg'
    ]);

    // Create the "Super Admin" role if it does not already exist
    $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);

    // Assign the "Super Admin" role to the user
    $adminUser->assignRole($superAdminRole);
    }
}
