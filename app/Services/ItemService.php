<?php namespace Owl\Services;

use Owl\Repositories\ItemRepositoryInterface;
use Owl\Repositories\ItemFtsRepositoryInterface;
use Owl\Repositories\ItemHistoryRepositoryInterface;

class ItemService extends Service
{
    protected $itemRepo;
    protected $itemFtsRepo;
    protected $itemHistoryRepo;

    public function __construct(
        ItemRepositoryInterface $itemRepo,
        ItemFtsRepositoryInterface $itemFtsRepo,
        ItemHistoryRepositoryInterface $itemHistoryRepo
    ) {
        $this->itemRepo = $itemRepo;
        $this->itemFtsRepo = $itemFtsRepo;
        $this->itemHistoryRepo = $itemHistoryRepo;
    }

    /**
     * Get a item by item id.
     *
     * @param int $item_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getById($item_id)
    {
        return $this->itemRepo->getById($item_id);
    }

    /**
     * Get a item by open item id.
     *
     * @param int $open_item_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getByOpenItemId($open_item_id)
    {
        return $this->itemRepo->getByOpenItemId($open_item_id);
    }

    /**
     * Get a item by open item id with comments.
     *
     * @param int $open_item_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getByOpenItemIdWithComment($open_item_id)
    {
        return $this->itemRepo->getByOpenItemIdWithComment($open_item_id);
    }

    /**
     * Get all published items.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getAllPublished()
    {
        return $this->itemRepo->getAllPublished();
    }

    /**
     * Get flow published items.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getAllFlowPublished()
    {
        return $this->itemRepo->getAllFlowPublished();
    }

    /**
     * Get stock published items.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getAllStockPublished()
    {
        return $this->itemRepo->getAllStockPublished();
    }

    /**
     * Get recent items by user id.
     *
     * @param int $user_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getRecentsByUserId($user_id)
    {
        return $this->itemRepo->getRecentsByUserId($user_id);
    }

    /**
     * Get recent items by user id with paginate.
     *
     * @param int $user_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getRecentsByUserIdWithPaginate($user_id)
    {
        return $this->itemRepo->getRecentsByUserIdWithPaginate($user_id);
    }

    /**
     * Get recent items by login user id with paginate.
     *
     * @param int $user_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getRecentsByLoginUserIdWithPaginate($user_id)
    {
        return $this->itemRepo->getRecentsByLoginUserIdWithPaginate($user_id);
    }

    /**
     * Get recent items by tag id.
     *
     * @param int $item_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getRecentsByTagId($tag_id)
    {
        return $this->itemRepo->getRecentsByTagId($tag_id);
    }

    /**
     * Get like users by item id.
     *
     * @param int $item_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getLikeUsersById($item_id)
    {
        return $this->itemRepo->getLikeUsersById($item_id);
    }

    /**
     * Create open item id.
     *
     * @return string
     */
    public function createOpenItemId()
    {
        return substr(md5(uniqid(rand(), 1)), 0, 20);
    }

    /**
     * Create a new item.
     *
     * @param $obj user_id, open_item_id, title, body, published
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($obj)
    {
        $item = $this->itemRepo->create($obj);
        $this->changeFts($item->id, $obj);

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
        $item = $this->itemRepo->update($id, $obj);
        $this->changeFts($id, $obj);

        return $item;
    }

    /**
     * change fts data. (delete and insert)
     *
     * @param int $id
     * @param object $obj
     * @return Illuminate\Database\Eloquent\Model
     */
    public function changeFts($id, $obj)
    {
        //delete & insert fts
        $this->itemFtsRepo->delete($id);
        return $this->itemFtsRepo->create($id, $obj->title, $obj->body);
    }

    /**
     * Delete a item.
     *
     * @param $item_id int
     * @return boolean
     */
    public function delete($item_id)
    {
        $this->itemFtsRepo->delete($item_id);
        $this->itemHistoryRepo->delete($item_id);
        return $this->itemRepo->delete($item_id);
    }

    /**
     * Create a item history.
     *
     * @param object $item
     * @param object $user
     * @return Illuminate\Database\Eloquent\Model
     */
    public function createHistory($item, $user)
    {
        return $this->itemHistoryRepo->create($item, $user);
    }

    /**
     * Get a item history by open item id.
     *
     * @param string $open_item_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getHistoryByOpenItemId($open_item_id)
    {
        return $this->itemHistoryRepo->getByOpenItemId($open_item_id);
    }
}
