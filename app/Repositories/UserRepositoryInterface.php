<?php namespace Owl\Repositories;

interface UserRepositoryInterface
{
    /**
     * Create a new user.
     *
     * @param mixed $credentials (email, username, password, role)
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($credentials);

    /**
     * Update a user information(username, email, role).
     *
     * @param int $id
     * @param string $username
     * @param string $email
     * @param int $role
     * @return Illuminate\Database\Eloquent\Model
     */
    public function update($id, $username, $email, $role);

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
     * Get a user by email.
     *
     * @param string $email
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getByEmail($email);

    /**
     * Get users by username like search.
     *
     * @param string $username
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getLikeUsername($username);

    /**
     * Get users which role is owner.
     *
     * @param string $username
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getOwners();

    /**
     * Get all user data.
     *
     * @return Illuminate\Database\Eloquent\Collection | Illuminate\Database\Eloquent\Builder
     */
    public function getAll();
}
