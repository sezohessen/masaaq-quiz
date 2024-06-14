<?php

namespace App\Interface\GoogleCalendar;

use App\Models\Quiz;
use Google_Client;
interface CalendarServiceInterface
{
    public function createEvent(Quiz $quiz): void;
    public function isAuthorized(): bool;
    public function initializeGoogleClient() :Google_Client;
    public function client() :Google_Client;
}
