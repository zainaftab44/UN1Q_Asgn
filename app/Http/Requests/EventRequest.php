<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:255',
            'summary' => 'nullable|string|max:255',
            'start_datetime' => 'required|date|after:now',
            'end_datetime' => 'required|date|after:start_datetime',
            'interval' => [
                'required',
                'string',
                Rule::in(['daily', 'monthly']),
            ],
            'occurrence' => 'required|integer|max_digits:2',
            'until_datetime' => 'required|date|after:end_datetime',
        ];
    }
}
