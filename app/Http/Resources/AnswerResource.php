<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            'is_correct' => $this->is_correct,
            'attempt' => new QuizResource($this->whenLoaded('attempt')),
            'question' => new QuestionResource($this->whenLoaded('question')),
            'choice' => new ChoiceResource($this->whenLoaded('choice')),
        ];
    }
}
