<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UploadImageRequest extends FormRequest
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
            // 定義驗證規則
            'image' => [
                'required',
                'file',
                function ($attribute, $value, $fail) {
                    $mimeType = $value->getMimeType();
                    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/pjpeg'];
                    if (!in_array($mimeType, $allowedMimeTypes)) {
                        $fail('The ' . $attribute . ' must be a valid image.');
                    }
                },
                'max:2048',
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     * @return array
     */
    public function messages(): array
    {
        return [
            'image.max' => 'The image is too large',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'message' => '資料驗證失敗',
        ], 422));
    }
}
