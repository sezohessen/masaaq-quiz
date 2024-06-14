<?php

namespace App\Http\Services\Tenant\Quiz\GoogleCalendar;

use Exception;
use Google_Client;
use App\Models\Quiz;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Illuminate\Support\Facades\Log;
use App\Interface\GoogleCalendar\CalendarServiceInterface;

class GoogleCalendarService implements CalendarServiceInterface
{
    public Google_Client $client;
    public function createEvent(Quiz $quiz): void
    {
        try {
            $service = new Google_Service_Calendar($this->client);

            $event = new Google_Service_Calendar_Event([
                'summary' => 'Quiz: ' . $quiz->title,
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
        } catch (Exception $e) {
            Log::error('Error initializing Google Client: ' . $e->getMessage());
            throw new Exception('Failed to initialize Google Client.');
        }
    }
    public function initializeGoogleClient(): Google_Client
    {
        try {
            $this->client = new Google_Client();
            $this->client->setAuthConfig(config_path('oauth-credentials.json'));
            $this->client->setRedirectUri(route('oauthcallback'));
            $this->client->addScope(Google_Service_Calendar::CALENDAR);
            // Set access type to offline to get refresh token
            $this->client->setAccessType('offline');
            // Set approval prompt to force to request a refresh token
            $this->client->setApprovalPrompt('force');

            return $this->client;
        } catch (Exception $e) {
            Log::error('Error initializing Google Client: ' . $e->getMessage());
            throw new Exception('Failed to initialize Google Client.');
        }
    }
    public function isAuthorized(): bool
    {

        $user = getAuth();
        if (empty($user->google_access_token)) {
            return false;
        }


        $accessToken = $user->google_access_token;
        if (isset($user->google_access_token['refresh_token']) && $this->checkToken($accessToken)) {
            return true;
        } else {
            return false;
        }
    }
    public function client(): Google_Client
    {
        return $this->client;
    }
    private function checkToken($accessToken)
    {
        $this->client->setAccessToken($accessToken);
        // Let's check if the access token is expired.
        if ($this->client->isAccessTokenExpired()) {
            $accessToken = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            $user = getAuth();
            $user->update(['google_access_token' => json_encode($accessToken)]);
        }

        return $this->client->getAccessToken() ? true : false;
    }
}
