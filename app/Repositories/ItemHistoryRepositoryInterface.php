<?php namespace Owl\Repositories;

interface ItemHistoryRepositoryInterface
{
    /**
     * Create a item history.
     *
     * @param object $item
     * @param object $user
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($item, $user);

    /**
     * Delete a item history.
     *
     * @param $item_id int
     * @return boolean
     */
    public function deleteItemHistory($item_id);

    /**
     * Get a item history by open item id.
     *
     * @param string $open_item_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getByOpenItemId($open_item_id);
}
