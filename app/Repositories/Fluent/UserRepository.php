<?php namespace Owl\Repositories\Fluent;

use Owl\Repositories\UserRepositoryInterface;
use Owl\Services\UserRoleService;

class UserRepository extends AbstractFluent implements UserRepositoryInterface
{
    protected $table = 'users';

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
     * Get a user by user_id.
     *
     * @param $id int
     * @return stdClass
     */
    public function getById($id)
    {
        return \DB::table($this->getTableName())
            ->where('id', $id)
            ->first();
    }

    /**
     * Create a new user.
     *
     * @param mixed $credentials (email, username, password, role)
     * @return stdClass
     */
    public function create($credentials)
    {
        $object = array();
        $object["username"] = $credentials->username;
        $object["email"] = $credentials->email;
        $object["password"] = password_hash($credentials->password, PASSWORD_DEFAULT);
        $object["role"] = $credentials->role;
        if ($user_id = $this->insert($object)) {
            $ret = $this->getById($user_id);
            return $ret;
        } else {
            return false;
        }
    }

    /**
     * Update a user information(username, email, role).
     *
     * @param int $id
     * @param string $username
     * @param string $email
     * @param int $role
     * @return stdClass
     */
    public function updateUser($id, $username, $email, $role)
    {
        $object = array();
        $object["username"] = $username;
        $object["email"] = $email;
        $object["role"] = $role;
        $wkey["id"] = $id;
        if ($ret = $this->update($object, $wkey)) {
            $user = $this->getById($id);
            return $user;
        } else {
            return false;
        }
    }

    /**
     * Get a user by username.
     *
     * @param string $username
     * @return stdClass
     */
    public function getByUsername($username)
    {
        return \DB::table($this->getTableName())
            ->where('username', $username)
            ->first();
    }

    /**
     * Get a user by email.
     *
     * @param string $email
     * @return stdClass
     */
    public function getByEmail($email)
    {
        return \DB::table($this->getTableName())
            ->where('email', $email)
            ->first();
    }

    /**
     * Get users by username like search.
     *
     * @param string $username
     * @return stdClass
     */
    public function getLikeUsername($username)
    {
        return \DB::table($this->getTableName())
            ->where('username', 'like', "$username%")
            ->get();
    }

    /**
     * Get users which role is owner.
     *
     * @param string $username
     * @return stdClass
     */
    public function getOwners()
    {
        return \DB::table($this->getTableName())
            ->where('role', UserRoleService::ROLE_ID_OWNER)
            ->get();
    }

    /**
     * Get all user data.
     *
     * @return stdClass
     */
    public function getAll()
    {
        $users =  \DB::table($this->getTableName())
            ->select('users.*', 'user_roles.name as role_name')
            ->join('user_roles', 'users.role', '=', 'user_roles.id')
            ->get();

        $i = 0;
        foreach ($users as $user) {
            $object = app('stdClass');
            $object->name = $user->role_name;
            $users[$i]->userRole = $object;
            $i++;
        }
        return $users;
    }

    /**
     * get users array
     * 
     * @param object $user
     * @return array
     */
    public function getUsersToArray($users)
    {
        $users_array = array();
        $i = 0;
        foreach ($users as $user) {
            $users_array[$i]["id"] = $user->id;
            $users_array[$i]["username"] = $user->username;
            $users_array[$i]["email"] = $user->email;
            $users_array[$i]["password"] = $user->password;
            $users_array[$i]["created_at"] = $user->created_at;
            $users_array[$i]["updated_at"] = $user->updated_at;
            $users_array[$i]["role"] = $user->role;
            $i++;
        }
        return $users_array;
    }
}
