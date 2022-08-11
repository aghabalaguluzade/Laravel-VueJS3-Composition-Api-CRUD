<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ["required"],
            'email' => ["required","email"],
            'description' => ["required"],
            'position' => ["required"],
            'salary' => ["required"]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ad bölümü mütləqdir!',
            'email.required' => 'Email bölümü mütləqdir!',
            'description.required' => 'Haqqında bölümü mütləqdir!',
            'position.required' => 'Vəzifə bölümü mütləqdir!',
            'salary.required' => 'Maaş bölümü mütlqədir!'
        ];
    }
}
