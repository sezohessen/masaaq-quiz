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
        $url = $this->getURL($tenant);
        URL::forceRootUrl($url);
    }
    public function getURL($tenant)
    {
        return 'http://' . $tenant->name.'.'. config('tenancy.central_domains')[0];
    }
    public function initializeTenancy()
    {
        $tenant = $this->createTenant();
        tenancy()->initialize($tenant);
        return $tenant;
    }
    public function createTenant()
    {
        (new RoleSeeder())->run();
        $seeder = (new TenantSeeder());
        return $seeder->run();
    }
}
