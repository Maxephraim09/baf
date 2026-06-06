<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Donation;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create a test superadmin user
        $user = User::firstOrCreate([
            'email' => 'admin@example.com'
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password123')
        ]);

        $role = Role::firstOrCreate(['name' => 'superadmin']);

        if (! $user->hasRole($role)) {
            $user->assignRole($role);
        }

        // Create sample projects
        Project::create([
            'title' => 'Clean Water Initiative',
            'description' => 'Providing clean water to rural communities',
            'goal_amount' => 100000,
            'raised_amount' => 45000,
            'location' => 'Africa',
            'status' => 'active'
        ]);

        Project::create([
            'title' => 'School Building Project',
            'description' => 'Building schools for underprivileged children',
            'goal_amount' => 150000,
            'raised_amount' => 78000,
            'location' => 'Asia',
            'status' => 'active'
        ]);

        // Add more seed data as needed
    }
}