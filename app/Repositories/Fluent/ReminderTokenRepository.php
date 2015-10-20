<?php namespace Owl\Repositories\Fluent;

use Owl\Repositories\ReminderTokenRepositoryInterface;

class ReminderTokenRepository extends AbstractFluent implements ReminderTokenRepositoryInterface
{
    protected $table = 'reminder_tokens';

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
     * Get reminder token data by user_id.
     * 
     * @param int $userId 
     * @return Object
     */
    public function getByUserId($userId)
    {
        return \DB::table($this->getTableName())
            ->where('user_id', $userId)
            ->first();
    }

    /**
     * Get reminder token data by token.
     * 
     * @param string $token
     * @return Object
     */
    public function getByToken($token)
    {
        return \DB::table($this->getTableName())
            ->where('token', $token)
            ->first();
    }
}
