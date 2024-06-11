<?php

namespace App\Http\Resources\Collection;
use App\Http\Resources\QuizAttemptResource;

class QuizAttemptCollection extends BaseCollection
{

  public $collects = QuizAttemptResource::class;

  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */

  public function toArray($request)
  {

    return $this->template();
  }
}
