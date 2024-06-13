<?php
use function Pest\Stressless\stress;
test('landing page',function(){
    $result = stress(env('APP_URL'))
    ->concurrently(1)
    ->for(10)->seconds()
    ->dump();
    expect($result->requests->failed->count)
    ->toBe(0);
    expect($result->requests->duration->med)
    ->toBeLessThan(15);
})->skip('W8 until domain production');
