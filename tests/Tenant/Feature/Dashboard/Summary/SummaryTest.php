<?php
use App\Models\Member;
use App\Models\Quiz;
beforeEach(function () {
    $this->client = $this->actAsClient();
});
it('can view summary page', function () {
    $response = $this->get(route('dashboard.index'));
    $response->assertStatus(200);
    $response->assertSee('Summary');
    $response->assertSee('Attempts');
    $response->assertSee(Quiz::count());
    $response->assertSee(Member::count());
});
