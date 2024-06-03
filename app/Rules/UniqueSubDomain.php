<?php

namespace App\Rules;

use App\Actions\CreateTenantAction;
use App\Models\Domain;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueSubdomain implements ValidationRule
{

    public function __construct()
    {
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $domain = CreateTenantAction::generateSubdomain($value);
        $domainQuery = Domain::where('domain', $domain);
        $userQuery = User::where('domain_name', $value);

        if ($domainQuery->exists() || $userQuery->exists()) {
            $fail(__("This domain  is already taken"));
        }
    }
}
