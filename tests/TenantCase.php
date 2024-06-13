<?php

namespace Tests;

use App\Models\Quiz;
use App\Models\User;
use Database\Seeders\MemberSeeder;
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
        $this->withoutVite();
    }
    public function initializeTenancy()
    {
        $tenant = $this->createTenant();
        initializeTenant($tenant);
        return $tenant;
    }
    public function actAsMember()
    {
        $member = (new MemberSeeder())->run();
        $this->actingAs($member);
        return $member;
    }
    public function actAsClient()
    {
        $client = User::where('email','client@client.com')->first();
        $this->actingAs($client);
        return $client;
    }
    public function createTenant()
    {
        (new RoleSeeder())->run();
        $seeder = (new TenantSeeder());
        return $seeder->run();
    }
    public function createQuizzes($count,$number_of_questions = 2)
    {
        return Quiz::factory()
        ->count($count)
        ->hasQuestions($number_of_questions)
        ->create();
    }
}
