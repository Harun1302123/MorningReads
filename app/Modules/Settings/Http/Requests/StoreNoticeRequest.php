<?php

namespace App\Modules\Settings\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreNoticeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules()
    {
        $rules = [];
        $rules['title_en'] = 'required';
        $rules['content_en'] = 'required';
        $rules['status'] = 'required';

        // Check if the user is uploading a new image
        if ($this->hasFile('image')) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg|max:1024';
        }
        return $rules;
    }

    /**
     * Set the validation message.
     *
     * @return array
     */
    public function messages()
    {
        $message = [];
        $message['title_en.required'] = 'The title english field is required.';
        $message['content_en.required'] = 'The content english field is required.';
        $message['status.required'] = 'The status field is required.';
        $message['image.required'] = 'The image field is required.';
        $message['image.image'] = 'The image must image file.';

        return $message;

    }



}
