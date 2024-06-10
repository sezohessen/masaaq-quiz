<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'quiz_type' => $this->quiz_type,
            'score' => $this->score,
            'number_of_questions' => $this->number_of_questions,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'isAvailableToStartNow' => $this->isAvailableToStartNow(),
            'isEnded' => $this->isEnded(),
            'questions' => QuestionResource::collection($this->whenLoaded('questions')),
        ];
    }
}
