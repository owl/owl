<?php namespace Owl\Http\Requests;

use Owl\Http\Requests\Request;

class UserRegisterRequest extends Request {

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
            'username' => 'required|alpha_num|reserved_word|max:30|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|alpha_num|min:4'
        ];
    }

}
