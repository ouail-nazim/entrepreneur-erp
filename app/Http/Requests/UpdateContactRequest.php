<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $contactId = $this->route('contact')->id;
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:contacts,email,' . $contactId,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'nin' => 'nullable|string|unique:contacts,nin,' . $contactId,
            'insurance_number' => 'nullable|string',
            'hire_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'managed_by' => 'nullable|exists:contacts,id',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:contact_roles,id',
        ];
    }
}
