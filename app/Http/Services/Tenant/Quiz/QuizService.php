<?php

namespace App\Http\Services\Tenant\Quiz;

use App\Jobs\SendQuizLink;
use App\Jobs\SendQuizReminder;
use App\Jobs\SendQuizResult;
use App\Jobs\SendQuizResultForOwner;
use App\Models\Answer;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\SubscribeQuiz;
use Illuminate\Support\Str;

class QuizService
{
    public function show($request, Quiz $quiz)
    {
        $quizzes = Quiz::inRandomOrder()->limit(6)->get();

        return view('tenant.quiz.show', compact('quiz', 'quizzes'));
    }

    public function subscribe($request, Quiz $quiz)
    {
        if ($quiz->isEnded()) {
            return redirect()->back()->with('error', __('Quiz is ended'));
        }

        $link = $this->uniqueLink();
        $this->subscribeQuiz($quiz->id, $link);
        $this->sendQuizLink($quiz, $link);

        if ($quiz->isInTime()) {
            $this->scheduleReminder($quiz, $link);
        }

        return redirect()->back()->with('success', __('You have subscribed for the quiz. You can start the quiz through the link that was sent via email.'));
    }

    public function subscribeQuiz($id, $link)
    {
        getAuth()->subscribed_quizzes()->create([
            'link' => $link,
            'quiz_id' => $id
        ]);
    }

    public function sendQuizLink($quiz, $link)
    {
        SendQuizLink::dispatch(getAuth(), $quiz, $link);
    }

    public function uniqueLink()
    {
        return route('quiz.begin', ['link' => Str::random(10)]);
    }

    public function scheduleReminder($quiz, $link)
    {
        $reminderTime = $quiz->start_time?->subHour();
        SendQuizReminder::dispatch(getAuth(), $quiz, $link)->delay($reminderTime);
    }
    public function begin($request, $link)
    {
        $subscribed = getAuth()->hasSubscribedQuiz($link);
        if (!$subscribed || getAuth()->hasFinishedQuizAttempt($link)) {
            return redirect()->route('home');
        }
        if (!$subscribed->quiz?->isAvailableToStartNow()) {
            return redirect()
                ->route('quiz.show', ['id' => $subscribed->quiz?->id, 'quiz' => $subscribed->quiz])
                ->with('error', __('Quiz is not available for now'));
        }
        $attempt = $this->insertAttempt($subscribed, $link);
        $quiz = $subscribed->quiz;
        $quiz->load('questions', 'questions.choices');
        return view('tenant.quiz.begin', compact('attempt', 'quiz'));

    }
    public function finish($request, QuizAttempt $quizAttempt)
    {
        $quiz = $quizAttempt->quiz()->with('questions.choices')->first();

        // Store answers
        $totalScore = $this->storeAnswerers($request, $quiz, $quizAttempt);
        $this->updateQuizAttempt($quizAttempt, $totalScore, $quiz);
        $this->sendQuizResult($quizAttempt);
        $this->sendQuizResultForOwner($quizAttempt);
        return redirect()->route('quiz.result', ['quiz_attempt' => $quizAttempt->id,'quiz' => $quiz->slug])->with('success', __('Quiz has been submitted successfully'));
    }
    public function sendQuizResult(QuizAttempt $quizAttempt)
    {
        $link = route('quiz.result',['quiz_attempt' => $quizAttempt?->id,'quiz' => $quizAttempt?->quiz?->slug]);
        SendQuizResult::dispatch(getAuth(), $quizAttempt, $link);
    }
    public function sendQuizResultForOwner(QuizAttempt $quizAttempt)
    {
        $owner = tenancy()->tenant->user?->email;
        $link = route('dashboard.quiz_attempt.show',['quiz_attempt' => $quizAttempt->id]);
        SendQuizResultForOwner::dispatch($owner,getAuth(),$quizAttempt, $link);
    }
    public function result($request, QuizAttempt $quizAttempt)
    {
        $quizAttempt->load(['answers','quiz','quiz.questions','quiz.questions.choices']);
        return view('tenant.quiz.result',compact('quizAttempt'));
    }
    public function updateQuizAttempt($quizAttempt, $totalScore, $quiz)
    {
        $passed = $totalScore >= ($quiz->score / 2);//Assume the pass percentage is 50%

        $quizAttempt->update([
            'score' => $totalScore,
            'passed' => $passed,
            'end_time' => now(),
            'has_finished' => true
        ]);
    }
    public function storeAnswerers($request, $quiz, $quizAttempt)
    {
        $totalScore = 0;
        foreach ($request->answers as $questionId => $choiceId) {
            $question = $quiz->questions()->find($questionId);
            $choice = $question->choices()->find($choiceId);

            $isCorrect = $choice->is_correct;

            if ($isCorrect) {
                $totalScore += $question->score;
            }
            Answer::create([
                'quiz_attempt_id' => $quizAttempt->id,
                'question_id' => $questionId,
                'choice_id' => $choiceId,
                'is_correct' => $isCorrect,
            ]);
        }
        return $totalScore;
    }
    public function insertAttempt($subscribed, $link)
    {
        if ($subscribed->has_started && $attempt = getAuth()->attempts()->where('link', $link)->where('has_finished',false)->first()) {
            return $attempt;
        } else {
            $subscribed->hasStarted();
            return getAuth()->attempts()->create([
                'quiz_id' => $subscribed->quiz?->id,
                'link' => $link,
                'start_time' => now()
            ]);
        }
    }
}
