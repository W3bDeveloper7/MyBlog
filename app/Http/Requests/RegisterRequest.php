<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        $id = $this->request->get('user_id');
        return [
            'name'=> 'required|min:5',
            'username' => 'required|unique:users,username,'.$id,
            'status'    => 'required|in:0,1',
            'password'  => 'required|min:8',
            'role_id'  => 'required|exists:roles,id',
        ];
    }
}
