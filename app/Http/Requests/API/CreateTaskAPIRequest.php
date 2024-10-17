<?php

namespace App\Http\Requests\API;

use App\Models\Task;
use InfyOm\Generator\Request\APIRequest;

class CreateTaskAPIRequest extends APIRequest
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
        return array(
            'title' => 'required|unique:tasks|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|in:pending,onging,completed|max:255',
            'due_date' => 'required|date|date_format:Y-m-d h:i:s|after:now',
            'user_id' => 'nullable',
            'deleted_at' => 'nullable',
            'created_at' => 'nullable',
            'updated_at' => 'nullable'
        );
    }
}
