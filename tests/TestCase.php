<?php

namespace Tests;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected $port = 8000;
    public function createClient()
    {
        $user = User::factory()->create();
        Role::firstOrCreate(['name' => User::CLIENT_ROLE]);
        $user->assignRole(User::CLIENT_ROLE);
        return $user;
    }
    public function actAsAdministrator()
    {
        (new RoleSeeder())->run();
        $this->actingAs(User::first());
    }
}
