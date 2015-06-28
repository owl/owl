<?php namespace Owl\Repositories;

interface UserRepositoryInterface
{
    public function create($credentials);

    public function update($id, $username, $email);

    public function getById($id);

    public function getByUsername($username);

    public function getLikeUsername($username);
}
