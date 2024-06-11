<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizAttemptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'score' => $this->score,
            'passed' => $this->passed,
            'link' => $this->link,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'has_finished' => $this->has_finished,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'quiz' => new QuizResource($this->whenLoaded('quiz')),
            'answers' => AnswerResource::collection($this->whenLoaded('answers')),
        ];
    }
}
