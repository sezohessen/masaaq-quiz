<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = ['Administrator', 'Client owner'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
        $this->createUser()->assignRole(User::ADMIN_ROLE);
        $this->createMember();

    }
    public function createMember()
    {
        return User::create([
            'email' => 'member1@account.com',
            'name' => 'Member1',
            'password' => createPassword('password')
        ]);
    }
    public function createUser()
    {
        return User::create([
            'email' => 'admin@admin.com',
            'name' => 'Admin',
            'password' => createPassword('password')
        ]);
    }
}
