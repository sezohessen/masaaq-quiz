<?php

namespace Tests;
use App\Actions\CreateTenantAction;
use App\Http\Services\Auth\Tenant\TenantService;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }
    protected $port = 8000;
    public function createClient($options = null)
    {
        $user = User::factory()->create($options);
        Role::firstOrCreate(['name' => User::CLIENT_ROLE]);
        $user->assignRole(User::CLIENT_ROLE);
        return $user;
    }
    public function actAsAdministrator()
    {
        (new RoleSeeder())->run();
        $this->actingAs(User::first());
    }
    public function createTenant($client, $domain = 'test')
    {
        $tenantService = new TenantService();
        return $tenantService->createSubdomain($client,'test');
    }
    public function createSubdomainName($domain)
    {
        $CreateTenantAction = new CreateTenantAction();
        return $CreateTenantAction->generateSubdomain($domain);
    }
}
