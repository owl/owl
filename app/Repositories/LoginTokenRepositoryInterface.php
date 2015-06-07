<?php namespace Owl\Repositories;

interface LoginTokenRepositoryInterface
{
    /**
     * Create a login token.
     *
     * @param $token object token, user_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function createLoginToken($token);

    /**
     * Delete a login token.
     *
     * @param $token string
     * @return boolean
     */
    public function deleteLoginTokenByToken($token);

    /**
     * Get a valid login token by token.
     *
     * @param $token string
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getValidLoginToken($token, $limit);
}
