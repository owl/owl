<?php namespace Owl\Authenticate\Driver;

/**
 * @copyright (c) owl
 */

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Owl\Authenticate\Driver\OwlUser;
use Owl\Services\UserService;
use Owl\Services\AuthService;

/**
 * Class OwlUserProvider
 *
 * @package Owl\Authenticate\Driver
 */
class OwlUserProvider implements UserProvider
{
    /** @var UserService */
    protected $userService;

    /** @var AuthService */
    protected $authService;

    /**
     * Create constructor.
     *
     * @param UserService  $userService
     * @param AuthService  $authService
     */
    public function __construct(
        UserService $userService,
        AuthService $authService
    ) {
        $this->userService = $userService;
        $this->authService = $authService;
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
        $this->userService->updateToken(
            $user->getAuthIdentifier(),
            $token
        );
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     * @return null
     */
    public function retrieveByCredentials(array $credentials)
    {
        return;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param array $credentials
     * @return true
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return true;
    }

    /**
     * Get the owl user.
     *
     * @param mixed  $user
     *
     * @return OwlUser
     */
    protected function getGitHubUser($user)
    {
        if (!is_null($user)) {
            return new OwlUser((array) $user);
        }
    }
}
