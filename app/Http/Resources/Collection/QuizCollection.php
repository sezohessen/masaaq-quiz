<?php

namespace App\Http\Resources\Collection;
use App\Http\Resources\QuizResource;

class QuizCollection extends BaseCollection
{

  public $collects = QuizResource::class;

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
