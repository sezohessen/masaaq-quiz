<?php
declare(strict_types=1);
use Illuminate\Support\Facades\Hash;

if (!function_exists('createPassword')) {
    function createPassword($password)
    {
        return Hash::make($password);
    }
}
if (!function_exists('getSubDomain')) {
    function getSubDomain()
    {
        return tenancy()->tenant?->name;
    }
}
if (!function_exists('getAuth')) {
    function getAuth()
    {
      return auth('sanctum')->user();
    }
}
if (!function_exists('forceRootUrl')) {
    function forceRootUrl($tenant, $port = null)
    {
        if($port) $url = 'http://' . $tenant->name.'.'. config('tenancy.central_domains')[0] . ':' . $port;
        else $url = 'http://' . $tenant->name.'.'. config('tenancy.central_domains')[0];
        URL::forceRootUrl($url);
    }
}
if (!function_exists('initializeTenant')) {
    function initializeTenant($tenantId)
    {
        tenancy()->initialize($tenantId);
    }
}
