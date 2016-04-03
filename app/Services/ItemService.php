<?php namespace Owl\Services;

use Owl\Services\SearchService;
use Owl\Repositories\ItemRepositoryInterface;
use Owl\Repositories\ItemHistoryRepositoryInterface;

class ItemService extends Service
{
    protected $searchService;
    protected $itemRepo;
    protected $itemHistoryRepo;

    public function __construct(
        ItemRepositoryInterface $itemRepo,
        ItemHistoryRepositoryInterface $itemHistoryRepo,
        SearchService $searchService
    ) {
        $this->itemRepo = $itemRepo;
        $this->itemHistoryRepo = $itemHistoryRepo;
        $this->searchService = $searchService;
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
     * Get all items.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getAll()
    {
        return $this->itemRepo->getAll();
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
        $item = $this->itemRepo->createItem($obj);
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
        $item = $this->itemRepo->updateItem($id, $obj);
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
        $this->searchService->itemDelete($id);
        return $this->searchService->itemCreate($id, $obj->title, $obj->body);
    }

    /**
     * Delete a item.
     *
     * @param $item_id int
     * @return boolean
     */
    public function delete($item_id)
    {
        $this->searchService->itemDelete($item_id);
        $this->itemHistoryRepo->deleteItemHistory($item_id);
        return $this->itemRepo->deleteItem($item_id);
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

    /**
     * get item tags array
     *
     * @param object $item
     * @return array
     */
    public function getTagsToArray($item)
    {
        return $this->itemRepo->getTagsToArray($item);
    }
}
