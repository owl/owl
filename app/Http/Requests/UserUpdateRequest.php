<?php namespace Owl\Http\Requests;

use Owl\Services\UserService;
use Owl\Http\Requests\Request;

class UserUpdateRequest extends Request
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

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
        $loginUser = $this->userService->getCurrentUser();
        return [
            "username" => "required|alpha_num|reserved_word|max:30|unique:users,username,$loginUser->id",
            "email" => "required|email|unique:users,email,$loginUser->id",
        ];
    }
}
