<?php

class CustomValidator extends Illuminate\Validation\Validator {
	/**
	 * Validate that an attribute contains only alphabetic characters.
	 * uオプションを(unicode)を外す。オーバーライド。
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateAlpha($attribute, $value)
	{
		return preg_match('/^\pL+$/', $value);
	}

	/**
	 * Validate that an attribute contains only alpha-numeric characters.
	 * uオプションを(unicode)を外す。オーバーライド。
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateAlphaNum($attribute, $value)
	{
		return preg_match('/^[\pL\pN]+$/', $value);
	}

	/**
	 * Validate that an attribute contains only alpha-numeric characters, dashes, and underscores.
	 * uオプションを(unicode)を外す。オーバーライド。
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateAlphaDash($attribute, $value)
	{
		return preg_match('/^[\pL\pN_-]+$/', $value);
	}

    /**
     * 半角英字&スペース
     */
    protected function validateAlphaSpace($attribute, $value) {
        return preg_match('/^[\pL\s]+$/',$value);
    }
}
