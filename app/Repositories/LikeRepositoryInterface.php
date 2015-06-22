<?php namespace Owl\Repositories;

interface LikeRepositoryInterface
{
    /**
     * get "Like data" or Store a "Like data".
     *
     * @param $user_id int user_id
     * @param $item_id int item_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function firstOrCreate($user_id, $item_id);

    /**
     * Delete a "Like data".
     *
     * @param $user_id int user_id
     * @param $item_id int item_id
     * @return boolean
     */
    public function delete($user_id, $item_id);

    /**
     * Get a "Like data".
     *
     * @param $user_id int user_id
     * @param $item_id int item_id
     * @return Illuminate\Database\Eloquent\Collection | Illuminate\Database\Eloquent\Builder
     */
    public function get($user_id, $item_id);
}
