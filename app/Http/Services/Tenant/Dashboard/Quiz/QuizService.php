<?php

namespace App\Http\Services\Tenant\Dashboard\Quiz;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class QuizService
{
    public function create($request)
    {
        return view('tenant_dashboard.dashboard.quiz.create');
    }
    public function store($request)
    {
        DB::beginTransaction();

        try {
            $quiz = $this->createQuiz($request);
            $this->createQuestionsAndChoices($quiz, $request);

            DB::commit();

            return redirect()->back()->with('success',__('Created Successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());//Sentry log
            return redirect()->back()->with('error',__('Something went wrong'));
        }
    }

    private function createQuiz($request)
    {
        return Quiz::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'quiz_type' => $request->quiz_type,
            'start_time' => $request->quiz_type == '1' ? $request->start_time : null,
            'end_time' => $request->quiz_type == '1' ? $request->end_time : null,
        ]);
    }

    private function createQuestionsAndChoices(Quiz $quiz, $request)
    {
        $totalScore = 0;
        $questionCount = count($request->questions);

        foreach ($request->questions as $index => $questionTitle) {
            $question = $this->createQuestion($quiz, $questionTitle, $request, $index);
            $totalScore += $question->score;

            $this->createChoices($question, $request, $index);
        }

        $quiz->update([
            'score' => $totalScore,
            'number_of_questions' => $questionCount,
        ]);
    }

    private function createQuestion(Quiz $quiz, $questionTitle, $request, $index)
    {
        return $quiz->questions()->create([
            'question' => $questionTitle,
            'slug' => Str::slug($questionTitle),
            'description' => $request->question_descriptions[$index],
            'score' => $request->question_scores[$index],
        ]);
    }

    private function createChoices(Question $question, $request, $index)
    {
        foreach ($request->choices[$index] as $choiceIndex => $choiceTitle) {
            $question->choices()->create([
                'title' => $choiceTitle,
                'is_correct' => in_array($choiceIndex, $request->is_corrects[$index]) ? 1 : 0,
                'order' => $request->choice_orders[$index][$choiceIndex],
                'description' => $request->choice_descriptions[$index][$choiceIndex],
            ]);
        }
    }
}
