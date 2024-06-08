<?php

namespace App\Http\Services\Tenant\Quiz;

use App\Jobs\SendQuizLink;
use App\Jobs\SendQuizReminder;
use App\Models\Quiz;
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
            $this->scheduleReminder($quiz,$link);
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
        return route('quiz.begin',['link' => Str::random(10)]);
    }

    public function scheduleReminder($quiz, $link)
    {
        $reminderTime = $quiz->start_time?->subHour();
        SendQuizReminder::dispatch(getAuth(), $quiz, $link)->delay($reminderTime);
    }
    public function begin($request, $link)
    {
        if (!$subscribed = getAuth()->hasSubscribedQuiz($link)) {//TODO: Use policies
            return abort(404);
        }
        if (!$subscribed->quiz?->isAvailableToStartNow()) {
            return redirect()
            ->route('quiz.show',['id' => $subscribed->quiz?->id,'quiz' => $subscribed->quiz])
            ->with('error',__('Quiz is not available for now'));
        }
        $attempt = $this->insertAttempt($subscribed,$link);
        $quiz = $subscribed->quiz;
        return view('tenant.quiz.begin',compact('attempt','quiz'));

    }
    public function insertAttempt($subscribed,$link)
    {
        if($subscribed->has_started){
            return getAuth()->attempts()->where('link',$link)->first();
        }else{
            $subscribed->hasStarted();
            return getAuth()->attempts()->create([
                'quiz_id' => $subscribed->quiz?->id,
                'link' => $link,
                'start_time' => now()
            ]);
        }
    }
}
