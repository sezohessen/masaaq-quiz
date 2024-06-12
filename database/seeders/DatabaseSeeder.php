<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            TenantSeeder::class,
        ]);
        $this->initializeTenant();
        $this->call([
            MemberSeeder::class,
            QuizSeeder::class,
            QuizAttemptSeeder::class
        ]);
    }
    public function initializeTenant()
    {
        $tenant = Tenant::first();
        initializeTenant($tenant->id);
    }
}
