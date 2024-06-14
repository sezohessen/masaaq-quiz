<?php

namespace App\Http\Controllers\Tenant\Quiz\GoogleCalendar;

use App\Http\Controllers\Controller;
use App\Interface\GoogleCalendar\CalendarServiceInterface;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Calendar;
use Exception;
use Illuminate\Support\Facades\Log;

class GoogleCalendarController extends Controller
{
    protected $calendarService;

    public function __construct(CalendarServiceInterface $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    public function authorizeURL(Request $request, Quiz $quiz)
    {
        try {
            $client = $this->initializeGoogleClient();
            $state = json_encode(['tenant_id' => tenant('id'), 'quiz_id' => $quiz->id]);
            $client->setState($state);

            return redirect()->away($client->createAuthUrl());
        } catch (Exception $e) {
            Log::error('Error generating Google authorization URL: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Failed to initiate Google Calendar authorization.');
        }
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            if ($request->has('code') && $request->has('state')) {
                $state = json_decode($request->state, true);
                initializeTenant($state['tenant_id']);

                $redirectURL = tenancy()->tenant->route('google-calendar.save-access-token', [
                    'code' => $request->get('code'),
                    'quiz_id' => $state['quiz_id']
                ]);
                return redirect($redirectURL);
            }

            return redirect()->route('home');
        } catch (Exception $e) {
            Log::error('Error handling Google callback: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Failed to handle Google Calendar callback.');
        }
    }

    public function saveAccessToken(Request $request)
    {
        try {
            if ($request->has('code') && $request->has('quiz_id')) {
                $client = $this->initializeGoogleClient();
                $client->authenticate($request->get('code'));
                $token = $client->getAccessToken();

                getAuth()->update(['google_access_token' => $token]);

                $quiz = Quiz::find($request->quiz_id);
                if ($quiz) {
                    $this->calendarService->createEvent($client, $quiz);
                }

                return redirect()->route('quiz.show', ['id' => $quiz->id, 'quiz' => $quiz->slug])
                    ->with('success', 'Google Calendar connected and event created successfully!');
            }

            return abort(404);
        } catch (Exception $e) {
            Log::error('Error saving Google access token: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Failed to save Google Calendar access token.');
        }
    }

    private function initializeGoogleClient()
    {
        try {
            $client = new Google_Client();
            $client->setAuthConfig(config_path('oauth-credentials.json'));
            $client->setRedirectUri(route('oauthcallback'));
            $client->addScope(Google_Service_Calendar::CALENDAR);
            return $client;
        } catch (Exception $e) {
            Log::error('Error initializing Google Client: ' . $e->getMessage());
            throw new Exception('Failed to initialize Google Client.');
        }
    }
}
