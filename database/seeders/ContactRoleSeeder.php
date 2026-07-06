<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Employee',
                'slug' => 'employee',
                'description' => 'Regular employee with standard permissions.',
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
                'description' => 'Team or department manager.',
            ],
            [
                'name' => 'Team Leader',
                'slug' => 'team-leader',
                'description' => 'Responsible for a small group of employees.',
            ],
        ];

        foreach ($roles as $role) {
            \App\Models\ContactRole::create($role);
        }
    }
}
