<?php

namespace App\Http\Requests\Auth\Tenant;

use App\Rules\UniqueSubdomain;
use Illuminate\Foundation\Http\FormRequest;

class CreateTenantFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'domain' => ['required','string','min:3','max:255',new UniqueSubdomain()],
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|min:10|max:255|unique:users,email',
            'password' => 'required|string|min:6|max:255',
        ];
    }
}
