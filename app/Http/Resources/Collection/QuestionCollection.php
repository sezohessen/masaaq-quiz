<?php

namespace App\Http\Resources\Collection;
use App\Http\Resources\QuestionResource;

class QuestionCollection extends BaseCollection
{

  public $collects = QuestionResource::class;

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
