<?php

namespace Database\Seeders;

use App\Http\Services\Auth\Tenant\TenantService;
use App\Models\User;
use Illuminate\Database\Seeder;
class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $client = $this->createUser();
        $client->assignRole(User::CLIENT_ROLE);
        $tenantService = new TenantService();
        $tenant = $tenantService->createSubdomain($client,'test');
        $client->update([
            'domain_name' => 'test',
            'tenant_id' => $tenant->id
        ]);
        return $tenant;

    }
    public function createUser()
    {
        return User::create([
            'email' => 'client@client.com',
            'name' => 'Client',
            'password' => createPassword('password')
        ]);
    }
}
