<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateEventRequest extends FormRequest
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
            //
            'title' => 'nullable|string|min:3|max:255',
            'summary' => 'nullable|string|max:255',
            'start_datetime' => 'nullable|date_format:"Y-m-d\TH:i"|after:now',
            'end_datetime' => 'nullable|date_format:"Y-m-d\TH:i"|after:start_datetime',
            'until_datetime' => 'nullable|date_format:"Y-m-d\TH:i"|after:end_datetime'
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
