<?php namespace Owl\Http\Requests;

use Owl\Http\Requests\Request;

class FlowTagStoreRequest extends Request {

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
            'tag_id' => 'required|integer',
        ];
	}
}
