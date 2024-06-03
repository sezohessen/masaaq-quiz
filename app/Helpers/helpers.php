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
