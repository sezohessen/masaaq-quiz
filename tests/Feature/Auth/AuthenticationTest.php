<?php

use App\Http\Services\Auth\Tenant\TenantService;
use App\Models\User;
use App\Providers\RouteServiceProvider;
test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::DASHBOARD);
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});
test('tenant login and redirect', function () {
    $client = $this->createClient();
    $tenant = $this->createTenant($client,'test');
    $response = $this->post('/login', [
        'email' => $client->email,
        'password' => 'password',
    ]);

    $this->assertGuest();
    $impersonate = DB::table('tenant_user_impersonation_tokens')->first();
    $this->assertDatabaseHas('tenant_user_impersonation_tokens',[
        'tenant_id' => $tenant->id,
        'user_id' => $client->id
    ]);
    initializeTenant($tenant->id);
    forceRootUrl($tenant);
    $redirectURL = route('impersonate',['token' => $impersonate->token]);
    $response->assertRedirect($redirectURL);
});
