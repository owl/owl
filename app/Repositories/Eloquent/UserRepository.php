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

    public function getById($id)
    {
        return $this->user->where('id', $id)->first();
    }

    public function getByUsername($username)
    {
        return $this->user->where('username', $username)->first();
    }

    public function getLikeUsername($username)
    {
        return $this->user->where('username', 'like', "$username%")->get();
    }
}
