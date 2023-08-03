<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);



        // Create roles
        $roles = ['Admin', 'Manager', 'Employee'];
        foreach ($roles as $roleName) {
            Role::create(['name' => $roleName]);
        }

        // Create permissions
        $permissions = [];
        for ($i = 1; $i <= 6; $i++) {
            $permissions[] = Permission::create(['name' => "permission$i"]);
        }

        // Create users
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => "User $i",
                'email' => "user$i@example.com",
                'password' => bcrypt('password'),
            ]);

            // Assign random roles to the user
            $user->assignRole($roles[array_rand($roles)]);

            // Assign random permissions to the user
            $user->givePermissionTo($permissions[array_rand($permissions)]);
            $user->givePermissionTo($permissions[array_rand($permissions)]);
        }
    }
}
