<?php
beforeEach(function () {
    $this->actAsAdministrator();
});
test('profile page is displayed', function () {

    $response = $this
        ->get('/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {

    $response = $this
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    getAuth()->refresh();

    $this->assertSame('Test User', getAuth()->name);
    $this->assertSame('test@example.com', getAuth()->email);
    $this->assertNull(getAuth()->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = getAuth();
    $response = $this
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account', function () {
    $user = getAuth();
    $response = $this
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNotNull($user->fresh()->deleted_at);
});

test('correct password must be provided to delete account', function () {

    $response = $this
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect('/profile');

    $this->assertNotNull(getAuth()->fresh());
});
