<?php namespace Owl\Http\Requests;

use Owl\Http\Requests\Request;

class TemplateUpdateRequest extends Request {

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
            'display_title' => 'required|max:255',
            'title' => 'required|max:255',
            'tags' => 'alpha_comma|max:64',
            'body' => 'required',
        ];
    }

}
