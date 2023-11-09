<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\APIRequest;

class ChangePasswordRequest extends APIRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'current_password' => 'required|min:6',
        'new_password' => 'required|min:6',
        ];
    }
}
