<?php

namespace App\Http\Controllers\Tenant\Quiz\GoogleCalendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Support\Facades\Session;


class GoogleCalendarController extends Controller
{
    public function authorizeURL(Request $request)
    {
        $client = $this->getClient();
        tenancy()->central(function ($tenant) {
            Session::put('google_calendar_tenant',$tenant->id);
        });
        return redirect()->away($client->createAuthUrl());
    }

    public function handleGoogleCallback(Request $request)
    {
        $tenant = Session::get('google_calendar_tenant');
        dd($tenant);
        if($tenant && $request->has('code')){
            dd($tenant , $request->has('code'));
            $this->initializeTenant($tenant->id);
            return redirect()->route('google-calendar.save-access-token',['code' => $request->get('code')]);
        }else{
            return redirect()->route('home');
        }
    }
    public function saveAccessToken(Request $request ,$code)
    {
        $client = $this->getClient();
        $client->authenticate($request->get('code'));
        $token = $client->getAccessToken();
        getAuth()->update([
            'google_access_token' => $token
        ]);
        dd(getAuth(),$code,$token);
        return redirect()->route('home')->with('success', 'Google Calendar connected successfully!');
    }
    private function initializeTenant($tenantId)
    {
        tenancy()->initialize($tenantId);
    }

    private function getClient()
    {
        $client = new Google_Client();
        $client->setAuthConfig(config_path('oauth-credentials.json'));
        $client->setRedirectUri(route('oauthcallback'));
        $client->addScope(Google_Service_Calendar::CALENDAR);
        return $client;
    }
}
