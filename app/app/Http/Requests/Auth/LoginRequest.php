<?php

namespace App\Http\Requests\Auth;

use App\Features\Auth\Dto\Credentials;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|string',
            'remember' => 'nullable|boolean',
        ];
    }

    public function getDto(): Credentials
    {
        return new Credentials(
            $this->get('email'),
            $this->get('password'),
            $this->get('remember'),
        );
    }
}
