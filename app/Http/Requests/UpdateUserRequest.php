<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'phone' => 'required|string|unique:users,phone,' . $userId,
            'association_id' => 'required|exists:associations,id',
            'profile_photo' => 'nullable|image|max:2048',
            'assign_role' => 'required|in:admin,membre',
        ];
    }
}
