<?php
use App\Models\User;
beforeEach(function () {
    $this->actAsAdministrator();
});
test('administrator can access dashboard', function () {
    $response = $this->get('/dashboard');
    $response->assertStatus(200);
});
test('create tenant required validation', function () {
    $response = $this->post('/dashboard/tenants/store');
    $response->assertStatus(302);
    $response->assertSessionHasErrors(['email','domain','name','password']);
});
test('tenant name is already been taken', function () {
    $domainName = 'test';
    $client = $this->createClient();
    $this->createTenant($client,$domainName);
    $response = $this->post('/dashboard/tenants/store',[
        'name' => fake()->name,
        'email' => fake()->email,
        'password' => 'password',
        'domain' => $domainName
    ]);
    $response->assertStatus(302);
    $response->assertSessionHasErrors(['domain']);
});
test('email is already been taken', function () {
    $client = $this->createClient([
        'email' => fake()->email
    ]);
    $response = $this->post('/dashboard/tenants/store',[
        'name' => fake()->name,
        'email' => $client->email,
        'password' => 'password',
        'domain' => fake()->name
    ]);
    $response->assertStatus(302);
    $response->assertSessionHasErrors(['email']);
});
test('it can create client', function () {
    $data = [
        'name' => fake()->name,
        'email' => fake()->email,
        'password' => 'password',
        'domain' => fake()->name
    ];
    $response = $this->post('/dashboard/tenants/store',$data);
    $response->assertRedirect(route('dashboard.tenants.index'));
    $domain_name = $this->createSubdomainName($data['domain']);
    $user = User::where('email',$data['email'])->first();
    $this->assertDatabaseHas('users',[
        'name' => $data['name'],
        'email' => $data['email'],
        'domain_name' => $domain_name,
        'tenant_id' => $user->client->id
    ]);
    $this->assertDatabaseHas('tenants',[
        'name' => $data['domain'],
        'email' => $data['email'],
        'user_id' => $user->id
    ]);
    $this->assertDatabaseHas('domains',[
        'tenant_id' => $user->client->id,
        'domain' => $domain_name
    ]);
});

