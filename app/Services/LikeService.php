<?php namespace Owl\Services;

use Owl\Repositories\LikeRepositoryInterface;

class LikeService extends Service
{
    protected $likeRepo;

    public function __construct(LikeRepositoryInterface $likeRepo)
    {
        $this->likeRepo = $likeRepo;
    }

    /**
     * get "Like data" or Store a "Like data".
     *
     * @param $user_id int user_id
     * @param $item_id int item_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function firstOrCreate($user_id, $item_id)
    {
        return $this->likeRepo->firstOrCreate($user_id, $item_id);
    }

    /**
     * Delete a "Like data".
     *
     * @param $user_id int user_id
     * @param $item_id int item_id
     * @return boolean
     */
    public function delete($user_id, $item_id)
    {
        return $this->likeRepo->destroy($user_id, $item_id);
    }

    /**
     * Get a "Like data".
     *
     * @param $user_id int user_id
     * @param $item_id int item_id
     * @return Illuminate\Database\Eloquent\Collection | Illuminate\Database\Eloquent\Builder
     */
    public function get($user_id, $item_id)
    {
        return $this->likeRepo->get($user_id, $item_id);
    }
}
