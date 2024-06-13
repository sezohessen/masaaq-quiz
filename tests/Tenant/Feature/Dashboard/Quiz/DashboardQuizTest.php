<?php
use App\Models\Choice;
use App\Models\Question;
use App\Models\Quiz;

beforeEach(function () {
    $this->client = $this->actAsClient();
    $this->data = [
        "title" => fake()->name,
        "description" => fake()->text,
        "quiz_type" => $type = fake()->boolean,
        "start_time" => $type ? now()->format('Y-m-d\TH:i') : null,
        "end_time" => $type ? now()->addHour()->format('Y-m-d\TH:i') : null,
        "questions" => [fake()->name, fake()->name],
        "question_descriptions" => [fake()->text, fake()->text],
        "question_scores" => [fake()->numberBetween(1, 5), fake()->numberBetween(1, 5)],
        "choices" => [
            0 => [
                0 => fake()->name,
                1 => fake()->name,
            ],
            1 => [
                0 => fake()->name,
                1 => fake()->name,
            ]
        ],
        "choice_orders" => [
            0 => [
                0 => fake()->numberBetween(1, 10),
                1 => fake()->numberBetween(1, 10),
            ],
            1 => [
                0 => fake()->numberBetween(1, 10),
                1 => fake()->numberBetween(1, 10),
            ]
        ],
        "choice_descriptions" => [
            0 => [
                0 => fake()->text,
                1 => fake()->text,
            ],
            1 => [
                0 => fake()->text,
                1 => fake()->text,
            ]
        ],
        "is_corrects" => [
            0 => [
                0 => "0"
            ],
            1 => [
                0 => "1"
            ]
        ]
    ];
});
it('can create quiz', function () {
    $response = $this->post(route('dashboard.quiz.store'), $this->data);
    $response->assertRedirect(route('dashboard.quiz.index'));
    $response->assertSessionHasNoErrors();
    $this->assertDatabaseHas('quizzes', [
        'title' => $this->data['title'],
        'description' => $this->data['description'],
        'quiz_type' => $this->data['quiz_type'],
    ]);
    $this->assertDatabaseHas('questions', [
        'question' => $this->data['questions'][0],
        'description' => $this->data['question_descriptions'][0],
        'score' => $this->data['question_scores'][0],
    ]);
    $this->assertDatabaseHas('questions', [
        'question' => $this->data['questions'][1],
        'description' => $this->data['question_descriptions'][1],
        'score' => $this->data['question_scores'][1],
    ]);
    $this->assertDatabaseHas('choices', [
        'title' => $this->data['choices'][0][0],
        'description' => $this->data['choice_descriptions'][0][0],
        'order' => $this->data['choice_orders'][0][0],
        'is_correct' => 1,
    ]);
    $this->assertDatabaseHas('choices', [
        'title' => $this->data['choices'][0][1],
        'description' => $this->data['choice_descriptions'][0][1],
        'order' => $this->data['choice_orders'][0][1],
        'is_correct' => 0,
    ]);
    $quiz = Quiz::where('title',$this->data['title'])->first();
    $this->assertEquals(2, $quiz->questions()->count());
    $this->assertEquals(2, $quiz->questions()->first()->choices()->count());
    $this->assertEquals(2, Question::count());
    $this->assertEquals(4, Choice::count());
});
