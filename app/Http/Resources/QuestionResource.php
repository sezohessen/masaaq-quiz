<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'question' => $this->question,
            'slug' => $this->slug,
            'description' => $this->description,
            'score' => $this->score,
            'quiz' => new QuizResource($this->whenLoaded('quiz')),
            'choices' => ChoiceResource::collection($this->whenLoaded('choices')),
        ];
    }
}
