<?php namespace Owl\Repositories\Eloquent;

use Owl\Repositories\LikeRepositoryInterface;
use Owl\Repositories\Eloquent\Models\Like;

class LikeRepository implements LikeRepositoryInterface
{
    protected $like;

    public function __construct(Like $like)
    {
        $this->like = $like;
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
        return $this->like->firstOrCreate(array('user_id'=> $user_id, 'item_id' => $item_id));
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
        return $this->like->whereRaw('user_id = ? and item_id = ?', array($user_id, $item_id))->delete();
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
        return $this->like->whereRaw('user_id = ? and item_id = ?', array($user_id, $item_id))->get();
    }
}
