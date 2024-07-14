<?php 

namespace App\Modules\Users\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_first_name' => 'required',
            'user_gender' => 'required',
            'user_type' => 'required',
            'user_mobile' => 'required|bd_mobile',
            'user_email' => 'required|email|unique:users',
        ];
    }

    public function messages(): array
    {
        return [
            'user_first_name.required' => 'The first name field is required',
            'user_gender.required' => 'The gender field is required',
            'user_type.required' => 'The user type field is required',
            'user_mobile.required' => 'The mobile number field is required',
            'user_email.required' => 'The email address field is required',
        ];
    }
}
