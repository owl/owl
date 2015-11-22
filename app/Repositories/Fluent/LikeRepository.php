<?php namespace Owl\Repositories\Fluent;

use Owl\Repositories\LikeRepositoryInterface;

class LikeRepository extends AbstractFluent implements LikeRepositoryInterface
{
    protected $table = 'likes';

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
     * Get a like by id.
     *
     * @param $id int
     * @return stdClass
     */
    public function getLikeById($id)
    {
        return \DB::table($this->getTableName())
            ->where($this->getTableName().'.id', $id)
            ->first();
    }

    /**
     * get "Like data" or Store a "Like data".
     *
     * @param $user_id int user_id
     * @param $item_id int item_id
     * @return stdClass
     */
    public function firstOrCreate($user_id, $item_id)
    {
        $likeData = \DB::table($this->getTableName())
            ->where($this->getTableName().'.user_id', $user_id)
            ->where($this->getTableName().'.item_id', $item_id)
            ->first();

        if (!empty($likeData)) {
            return $likeData;
        }

        $object = array();
        $object["user_id"] = $user_id;
        $object["item_id"] = $item_id;
        $like_id = $this->insert($object);
        return $this->getLikeById($like_id);
    }

    /**
     * Delete a "Like data".
     *
     * @param $user_id int user_id
     * @param $item_id int item_id
     * @return boolean
     */
    public function destroy($user_id, $item_id)
    {
        return \DB::table($this->getTableName())
            ->where('user_id', '=', $user_id)
            ->where('item_id', '=', $item_id)
            ->delete();
    }

    /**
     * Get a "Like data".
     *
     * @param $user_id int user_id
     * @param $item_id int item_id
     * @return stdClass
     */
    public function get($user_id, $item_id)
    {
        return \DB::table($this->getTableName())
            ->where('user_id', '=', $user_id)
            ->where('item_id', '=', $item_id)
            ->first();
    }
}
