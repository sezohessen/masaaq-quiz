<?php

namespace App\Actions;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Str;

class CreateTenantAction
{
    public function __invoke(string $domain,User $user): Tenant
    {

        $tenant = Tenant::create([
            "user_id"=> $user->id,
            "ready" => true,
            "email"=> $user->email,
            "name" => $user->name,
        ]);

        $tenant->createDomain([
            "domain" => self::generateSubdomain($domain),
        ]);

        return $tenant;
    }
    public static function generateSubdomain($text){
        $transliterated = Str::slug($text);

        return $transliterated;
    }


}
