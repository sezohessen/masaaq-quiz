<?php

namespace App\Http\Resources\Collection;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\QuizResource;

class AnswerCollection extends BaseCollection
{

  public $collects = AnswerResource::class;

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
