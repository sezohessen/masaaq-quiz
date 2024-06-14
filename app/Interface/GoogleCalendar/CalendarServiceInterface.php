<?php

namespace App\Interface\GoogleCalendar;

use App\Models\Quiz;
use Google_Client;

interface CalendarServiceInterface
{
    public function createEvent(Google_Client $client, Quiz $quiz): void;
}
