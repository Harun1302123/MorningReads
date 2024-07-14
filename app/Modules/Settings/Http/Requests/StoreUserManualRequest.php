<?php

namespace App\Modules\Settings\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserManualRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules['title'] = 'required';


        return $rules;
    }

    /**
     * Set the validation message.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',

        ];
    }
}
