<?php namespace Owl\Repositories\Fluent;

use Owl\Repositories\ItemHistoryRepositoryInterface;

class ItemHistoryRepository extends AbstractFluent implements ItemHistoryRepositoryInterface
{
    protected $table = 'items_history';

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
     * Get a item history by item history id.
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
     * Create a item history.
     *
     * @param object $item
     * @param object $user
     * @return stdClass
     */
    public function create($item, $user)
    {
        if ($item->published === '0') {
            return;
        }
        $object = array();
        $object["item_id"] = $item->id;
        $object["user_id"] = $user->id;
        $object["open_item_id"] = $item->open_item_id;
        $object["title"] = $item->title;
        $object["body"] = $item->body;
        $object["published"] = $item->published;
        $item_history_id = $this->insert($object);

        $ret = $this->getById($item_history_id);
        return $ret;
    }

    /**
     * Delete a item history.
     *
     * @param $item_id int
     * @return boolean
     */
    public function deleteItemHistory($item_id)
    {
        $object = array();
        $wkey["item_id"] = $item_id;
        $ret = $this->delete($wkey);
        return $ret;
    }

    /**
     * Get a item history by open item id.
     *
     * @param string $open_item_id
     * @return stdClass
     */
    public function getByOpenItemId($open_item_id)
    {
        $itemHistories = \DB::table($this->getTableName())
            ->select(
                'items_history.*',
                'users.id as user_id',
                'users.email as user_email',
                'users.username as user_username'
            )
            ->join('users', 'items_history.user_id', '=', 'users.id')
            ->where('items_history.open_item_id', $open_item_id)
            ->orderBy('items_history.updated_at', 'DESC')
            ->get();

        $i = 0;
        foreach ($itemHistories as $itemHistory) {
            $object = app('stdClass');
            $object->id = $itemHistory->user_id;
            $object->email = $itemHistory->user_email;
            $object->username = $itemHistory->user_username;
            $itemHistories[$i]->user = $object;
            $i++;
        }
        return $itemHistories;
    }
}
