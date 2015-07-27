<?php namespace Owl\Repositories\Eloquent;

use Owl\Repositories\ItemRepositoryInterface;
use Owl\Repositories\Eloquent\Models\Item;

class ItemRepository implements ItemRepositoryInterface
{
    protected $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * Get a item by item id.
     *
     * @param int $item_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getById($item_id)
    {
        return $this->item->find($item_id);
    }

    /**
     * Get a item by open item id.
     *
     * @param int $open_item_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getByOpenItemId($open_item_id)
    {
        return $this->item->where('open_item_id', $open_item_id)->first();
    }

    /**
     * Get a item by open item id with comments.
     *
     * @param int $open_item_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getByOpenItemIdWithComment($open_item_id)
    {
        return $this->item->with('comment.user')->where('open_item_id', $open_item_id)->first();
    }

    /**
     * Get all published items.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getAllPublished()
    {
        return $this->item->with('user')
                    ->where('published', '2')
                    ->orderBy('updated_at', 'desc')
                    ->paginate(10);
    }

    /**
     * Get recent items by user id.
     *
     * @param int $user_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getRecentsByUserId($user_id)
    {
        return $this->item->with('user')
                    ->where('published', '2')
                    ->where('user_id', $user_id)
                    ->orderBy('id', 'desc')
                    ->take(5)->get();
    }

    /**
     * Get recent items by user id with paginate.
     *
     * @param int $user_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getRecentsByUserIdWithPaginate($user_id)
    {
        return $this->item->with('user')
                    ->where('published', '2')
                    ->where('user_id', $user_id)
                    ->orderBy('id', 'desc')
                    ->paginate(10);
    }

    /**
     * Get recent items by login user id with paginate.
     *
     * @param int $user_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getRecentsByLoginUserIdWithPaginate($user_id)
    {
        return $this->item->with('user')
                    ->where('user_id', $user_id)
                    ->orderBy('id', 'desc')
                    ->paginate(10);
    }

    /**
     * Get recent items by tag id.
     *
     * @param int $item_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getRecentsByTagId($tag_id)
    {
        return \DB::table('items')
                    ->join('users', 'items.user_id', '=', 'users.id')
                    ->join('tags', 'tags.id', '=', 'item_tag.tag_id')
                    ->join('item_tag', 'items.id', '=', 'item_tag.item_id')
                    ->where('tags.id', $tag_id)
                    ->where('published', '2')
                    ->select('users.email', 'users.username', 'items.open_item_id', 'items.updated_at', 'items.title')
                    ->orderBy('items.id', 'desc')
                    ->paginate(10);
    }

    /**
     * Get like users by item id.
     *
     * @param int $item_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getLikeUsersById($item_id)
    {
        return $this->item->with('like.user')->where('id', $item_id)->first();
    }

    /**
     * Create a new item.
     *
     * @param $obj user_id, open_item_id, title, body, published
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($obj)
    {
        $item = $this->item->newInstance();
        $item->user_id = $obj->user_id;
        $item->open_item_id = $obj->open_item_id;
        $item->title = $obj->title;
        $item->body = $obj->body;
        $item->published = $obj->published;
        $item->save();

        return $item;
    }

    /**
     * Update a item.
     *
     * @param $item_id
     * @param $obj user_id, open_item_id, title, body, published
     * @return Illuminate\Database\Eloquent\Model
     */
    public function update($id, $obj)
    {
        $item = $this->getById($id);
        $item->user_id = $obj->user_id;
        $item->title = $obj->title;
        $item->body = $obj->body;
        $item->published = $obj->published;
        $item->save();

        return $item;
    }

    /**
     * Delete a item.
     *
     * @param $item_id int
     * @return boolean
     */
    public function delete($item_id)
    {
        return $this->item->where('id', $item_id)->delete();
    }
}
