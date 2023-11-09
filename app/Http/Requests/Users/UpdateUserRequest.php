<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\APIRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends APIRequest
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
        $id = Auth::id();
        return [
            'current_password' => 'required|min:5',
            'mobile_number' => ['nullable','string', Rule::unique('users')->ignore($id)],
            'email' => ['nullable','string','email','max:50', Rule::unique('users')->ignore($id)],
            'fullname' => 'nullable|string'
            
        ];
    }
}
