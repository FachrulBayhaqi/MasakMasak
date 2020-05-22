<?php

namespace App\Http\Requests;

use App\Recipe;
use Illuminate\Foundation\Http\FormRequest;

class CreateRecipeRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:50',
            'subject' => 'required|string|max:50',
            'recipe' => 'required|string|max:450',
            'category' => 'required|string|max:50',
            'image' => 'sometimes|required|string'
        ];
    }
}
