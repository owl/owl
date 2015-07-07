<?php namespace Owl\Services;

use Owl\Repositories\UserRepositoryInterface;
use Owl\Repositories\LoginTokenRepositoryInterface;
use Carbon\Carbon;

class UserService extends Service
{
    protected $userRepo;
    protected $loginTokenRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
        LoginTokenRepositoryInterface $loginTokenRepo
    ) {
        $this->userRepo = $userRepo;
        $this->loginTokenRepo = $loginTokenRepo;
    }

    public function getCurrentUser()
    {
        if (\Session::has('User')) {
            $user = \Session::get('User');
            return $user[0];
        }
        return false;
    }

    /**
     * Create a new user.
     *
     * @param mixed $credentials (email, username, password)
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create(array $credentials = [])
    {
        $object = app('stdClass');
        $object->username = $credentials['username'];
        $object->email = $credentials['email'];
        $object->password = $credentials['password'];
        return $this->userRepo->create($object);
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
        return $this->userRepo->update($id, $username, $email);
    }

    /**
     * Get a user by user id.
     *
     * @param int $id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getById($id)
    {
        return $this->userRepo->getById($id);
    }

    /**
     * Get a user by username.
     *
     * @param string $username
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getByUsername($username)
    {
        return $this->userRepo->getByUsername($username);
    }

    /**
     * Get users by username like search.
     *
     * @param string $username
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getLikeUsername($username)
    {
        return $this->userRepo->getLikeUsername($username);
    }

    /**
     * Get a user by login token.
     *
     * @param string $token
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getByToken($token)
    {
        $TWO_WEEKS = 14;
        $limit = Carbon::now()->subDays($TWO_WEEKS);

        $tokenResult = $this->loginTokenRepo->getValidLoginToken($token, $limit);
        if (isset($tokenResult)) {
            $user = $this->getById($tokenResult->user_id);
            return $user;
        } else {
            return false;
        }
    }
}
