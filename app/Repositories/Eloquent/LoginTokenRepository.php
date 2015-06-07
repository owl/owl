<?php namespace Owl\Repositories\Eloquent;

use Owl\Repositories\LoginTokenRepositoryInterface;
use Owl\Repositories\Eloquent\Models\LoginToken;

class LoginTokenRepository implements LoginTokenRepositoryInterface
{
    protected $loginToken;

    public function __construct(LoginToken $loginToken)
    {
        $this->loginToken = $loginToken;
    }

    /**
     * Create a login token.
     *
     * @param $tkn object token, user_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function createLoginToken($tkn)
    {
        $token = $this->loginToken->newInstance();
        $token->token = $tkn->token;
        $token->user_id = $tkn->user_id;
        $token->save();

        return $token;
    }

    /**
     * Delete a login token.
     *
     * @param $token string
     * @return boolean
     */
    public function deleteLoginTokenByToken($token)
    {
        return $this->loginToken->where('token', '=', $token)->delete();
    }

    /**
     * Get a valid login token by token.
     *
     * @param $token string
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getValidLoginToken($token, $limit)
    {
        return $this->loginToken->where('token', $token)->where('updated_at', '>', $limit)->first();
    }
}
