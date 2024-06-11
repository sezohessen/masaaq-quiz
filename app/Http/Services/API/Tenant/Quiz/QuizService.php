<?php

namespace App\Http\Services\API\Tenant\Quiz;
use App\Http\Resources\Collection\QuizAttemptCollection;
use App\Http\Resources\Collection\QuizCollection;
use App\Http\Resources\QuizAttemptResource;
use App\Http\Resources\QuizResource;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Traits\ApiHelpersTrait;
use App\Http\Services\Tenant\Quiz\QuizService as TenantQuizService;
class QuizService
{
    use ApiHelpersTrait;
    public function __construct(public TenantQuizService $quizService)
    {
    }
    public function get($request)
    {
        $quizzes = $this->getQuizzes($request);
        return $this->success('Quizzes',new QuizCollection($quizzes));
    }
    public function show($request,$quiz)
    {
        return $this->success('Quiz',new QuizResource($quiz));
    }
    public function subscribe($request,$quiz)
    {
        if ($quiz->isEnded()) {
            return $this->sendError('Quiz is ended');
        }

        $this->quizService->handleSubscribeQuiz($quiz);
        return $this->success('You have subscribed for the quiz. You can start the quiz through the link that was sent via email.');
    }
    public function begin($request,$link)
    {
        $subscribed = getAuth()->hasSubscribedQuiz($link);
        if (!$subscribed || getAuth()->hasFinishedQuizAttempt($link) || !$subscribed->quiz?->isAvailableToStartNow()) {
            return $this->sendError('Quiz is not available for now.');
        }
        $attempt = $this->quizService->insertAttempt($subscribed, $link);
        $quiz = $subscribed->quiz;
        $quiz->load('questions', 'questions.choices');
        return $this->success('Quiz',[
            'quiz' => new QuizResource($quiz),
            'attempt' => $attempt
        ]);
    }
    public function finish($request,QuizAttempt $quizAttempt)
    {
        $attempt = $this->quizService->handleFinishedQuiz($request, $quizAttempt);
        return $this->success('Quiz has been submitted successfully',$attempt);
    }
    public function result($request,QuizAttempt $quizAttempt)
    {
        $quizAttempt->load(['answers','answers.question','answers.choice','quiz','quiz.questions','quiz.questions.choices']);
        return $this->success('Result',new QuizAttemptResource($quizAttempt));
    }
    public function attempts($request)
    {
        $attempts = $this->getAttempts($request);
        return $this->success('Result',new QuizAttemptCollection($attempts));
    }
    public function getQuizzes($request)
    {
        return Quiz::orderBy('id','desc')
        ->whenSearch($request['search'])
        ->whenType($request['type'])
        ->paginate($request['perPage'] ?? config('application.perPage',10));
    }
    public function getAttempts($request)
    {
        return QuizAttempt::orderBy('id','desc')
        ->with(['quiz'])
        ->whenSearch($request['search'] ?? null)
        ->whenFinished($request['finished'] ?? null)
        ->paginate($request['perPage'] ?? config('application.perPage',10));
    }

}
