<?php

namespace Tests;

use Database\Seeders\RoleSeeder;
use Database\Seeders\TenantSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\URL;

abstract class TenantCase extends BaseTestCase
{
    use CreatesApplication;
    protected $tenancy = false;
    protected function setUp(): void
    {
        parent::setUp();
        $tenant  = $this->initializeTenancy();
        forceRootUrl($tenant);
    }
    public function initializeTenancy()
    {
        $tenant = $this->createTenant();
        initializeTenant($tenant);
        return $tenant;
    }
    public function createTenant()
    {
        (new RoleSeeder())->run();
        $seeder = (new TenantSeeder());
        return $seeder->run();
    }
}
