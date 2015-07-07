<?php namespace Owl\Repositories;

interface UserRepositoryInterface
{
    /**
     * Create a new user.
     *
     * @param mixed $credentials (email, username, password)
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($credentials);

    /**
     * Update a user information(username, email).
     *
     * @param int $id
     * @param string $username
     * @param string $email
     * @return Illuminate\Database\Eloquent\Model
     */
    public function update($id, $username, $email);

    /**
     * Get a user by user id.
     *
     * @param int $id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getById($id);

    /**
     * Get a user by username.
     *
     * @param string $username
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getByUsername($username);

    /**
     * Get users by username like search.
     *
     * @param string $username
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getLikeUsername($username);
}
