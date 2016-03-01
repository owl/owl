<?php namespace Owl\Authenticate\Driver;

/**
 * @copyright (c) owl
 */

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Owl\Authenticate\Driver\OwlUser;
use Owl\Services\UserService;

/**
 * Class OwlUserProvider
 *
 * @package Owl\Authenticate\Driver
 */
class OwlUserProvider implements UserProvider
{
    /** @var UserService */
    protected $userService;

    /**
     * Create constructor.
     *
     * @param UserService  $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Retrieve a user by unique identifer.
     *
     * @param mixed  $identifier
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $user = $this->userService->getById($identifier);
        return $this->getOwlUser($user);
    }

    /**
     * Retrieve a user by unique token and identifier.
     *
     * @param mixed   $identifier
     * @param string  $token
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $user = $this->userService->getByToken($token);

        if (!$user) {
            return null;
        }

        return $this->getOwlUser($user);
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string  $token
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        $this->userService->updateToken($user->getAuthIdentifier(), $token);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        // Do not allowing login without password.
        if (!array_key_exists('password', $credentials)) {
            return;
        }

        unset($credentials['password']);

        $user = $this->userService->getUser($credentials);

        return $this->getOwlUser($user);
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $password = $user->getAuthPassword();

        if (password_verify($credentials['password'], $password)) {
            return true;
        }

        // 不正なパスワード
        return false;
    }

    /**
     * Get the owl user.
     *
     * @param mixed  $user
     *
     * @return OwlUser|null
     */
    protected function getOwlUser($user)
    {
        if (!is_null($user)) {
            return new OwlUser((array) $user);
        }
    }
}
