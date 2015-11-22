<?php namespace Owl\Repositories\Fluent;

use Owl\Repositories\LoginTokenRepositoryInterface;

class LoginTokenRepository extends AbstractFluent implements LoginTokenRepositoryInterface
{
    protected $table = 'login_tokens';

    /**
     * Get a table name.
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->table;
    }

    /**
     * Create a login token.
     *
     * @param $token object token, user_id
     * @return stdClass
     */
    public function createLoginToken($token)
    {
        $object = array();
        $object["token"] = $token->token;
        $object["user_id"] = $token->user_id;
        $login_token_id = $this->insert($object);

        $ret = $this->getLoginTokenById($login_token_id);
        return $ret;
    }

    /**
     * Delete a login token.
     *
     * @param $token string
     * @return boolean
     */
    public function deleteLoginTokenByToken($token)
    {
        $object = array();
        $wkey["token"] = $token;
        $ret = $this->delete($wkey);
        return $ret;
    }

    /**
     * Get a valid login token by token.
     *
     * @param $token string
     * @return stdClass
     */
    public function getValidLoginToken($token, $limit)
    {
        return \DB::table($this->getTableName())
            ->where($this->getTableName().'.token', $token)
            ->where($this->getTableName().'.updated_at', '>', $limit)
            ->first();
    }

    /**
     * Get a login_token by id.
     *
     * @param $id int
     * @return stdClass
     */
    public function getLoginTokenById($id)
    {
        return \DB::table($this->getTableName())
            ->where($this->getTableName().'.id', $id)
            ->first();
    }
}
