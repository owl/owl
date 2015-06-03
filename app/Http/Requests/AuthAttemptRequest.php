<?php namespace Owl\Http\Requests;

use Owl\Http\Requests\Request;

class AuthAttemptRequest extends Request
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
            'username' => 'required|alpha_num|max:30',
            'password' => 'required|alpha_num|min:4'
        ];
    }
}
