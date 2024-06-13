<?php
beforeEach(function () {
    $this->quizzes = $this->createQuizzes(1);
    $this->quiz = $this->quizzes->first();
    $this->member = $this->actAsMember();
});
it('can show quiz page', function () {
    $response = $this->get('/quiz/start-quiz/'.$this->quiz->id.'/'.$this->quiz?->slug);
    $response->assertStatus(200);
    $response->assertSee($this->quiz->title);
    $response->assertSee($this->quiz->description);
    $response->assertSee($this->quiz->type);
});
