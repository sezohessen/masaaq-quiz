<?php

it('returns a successful response on tenant home page', function () {
    $response = $this->get('/');
    $response->assertSee('Home');
    $response->assertSee('Welcome to '.tenancy()->tenant->name);
    $response->assertStatus(200);
});
