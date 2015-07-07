<?php namespace Owl\Repositories\Eloquent;

use Owl\Repositories\UserRepositoryInterface;
use Owl\Repositories\Eloquent\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Create a new user.
     *
     * @param mixed $credentials (email, username, password)
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($credentials)
    {
        $user = $this->user->newInstance();
        $user->username = $credentials->username;
        $user->email = $credentials->email;
        $user->password = password_hash($credentials->password, PASSWORD_DEFAULT);

        if ($user->save()) {
            return $user;
        } else {
            return false;
        }
    }

    /**
     * Update a user information(username, email).
     *
     * @param int $id
     * @param string $username
     * @param string $email
     * @return Illuminate\Database\Eloquent\Model
     */
    public function update($id, $username, $email)
    {
        $user = $this->getById($id);
        if (!$user) {
            return false;
        }
        $user->username = $username;
        $user->email = $email;
        $user->save();

        if ($user->save()) {
            return $user;
        } else {
            return false;
        }
    }

    /**
     * Get a user by user id.
     *
     * @param int $id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getById($id)
    {
        return $this->user->where('id', $id)->first();
    }

    /**
     * Get a user by username.
     *
     * @param string $username
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getByUsername($username)
    {
        return $this->user->where('username', $username)->first();
    }

    /**
     * Get users by username like search.
     *
     * @param string $username
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getLikeUsername($username)
    {
        return $this->user->where('username', 'like', "$username%")->get();
    }
}
