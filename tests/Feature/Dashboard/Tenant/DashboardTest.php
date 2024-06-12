<?php
beforeEach(function () {
    $this->actAsAdministrator();
});
test('administrator can access dashboard', function () {
    $response = $this->get('/dashboard');

    $response->assertStatus(200);
});

