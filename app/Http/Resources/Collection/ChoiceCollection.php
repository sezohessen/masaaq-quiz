<?php

namespace App\Http\Resources\Collection;
use App\Http\Resources\ChoiceResource;

class ChoiceCollection extends BaseCollection
{

  public $collects = ChoiceResource::class;

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
