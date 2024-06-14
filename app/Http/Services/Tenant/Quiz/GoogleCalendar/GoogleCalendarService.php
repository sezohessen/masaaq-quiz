<?php

namespace App\Http\Services\Tenant\Quiz\GoogleCalendar;

use App\Interface\GoogleCalendar\CalendarServiceInterface;
use App\Models\Quiz;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class GoogleCalendarService implements CalendarServiceInterface
{
    public function createEvent(Google_Client $client, Quiz $quiz): void
    {
        $service = new Google_Service_Calendar($client);

        $event = new Google_Service_Calendar_Event([
            'summary' => 'Quiz: ' . $quiz->name,
            'description' => 'Reminder for quiz: ' . $quiz->description,
            'start' => [
                'dateTime' => $quiz->start_time->toRfc3339String(),
                'timeZone' => config('app.timezone'),
            ],
            'end' => [
                'dateTime' => $quiz->end_time->toRfc3339String(),
                'timeZone' => config('app.timezone'),
            ],
            'reminders' => [
                'useDefault' => false,
                'overrides' => [
                    ['method' => 'email', 'minutes' => 24 * 60], // 24 hours before
                    ['method' => 'popup', 'minutes' => 10], // 10 minutes before
                ],
            ],
        ]);

        $calendarId = 'primary';
        $service->events->insert($calendarId, $event);
    }
}
