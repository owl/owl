<?php namespace Owl\Repositories\Eloquent;

use Owl\Repositories\ItemHistoryRepositoryInterface;
use Owl\Repositories\Eloquent\Models\ItemHistory;

class ItemHistoryRepository implements ItemHistoryRepositoryInterface
{
    protected $itemHistory;

    public function __construct(ItemHistory $itemHistory)
    {
        $this->itemHistory = $itemHistory;
    }

    /**
     * Create a item history.
     *
     * @param object $item
     * @param object $user
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($item, $user)
    {
        if ($item->published === '0') {
            return;
        }

        $his = $this->itemHistory->newInstance();
        $his->item_id = $item->id;
        $his->user_id = $user->id;
        $his->open_item_id = $item->open_item_id;
        $his->title = $item->title;
        $his->body = $item->body;
        $his->published = $item->published;
        $his->save();

        return $his;
    }

    /**
     * Delete a item history.
     *
     * @param $item_id int
     * @return boolean
     */
    public function delete($item_id)
    {
        return $this->itemHistory->where('item_id', $item_id)->delete();
    }

    /**
     * Get a item history by open item id.
     *
     * @param string $open_item_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getByOpenItemId($open_item_id)
    {
        return $this->itemHistory->with('user')
            ->where('open_item_id', $open_item_id)
            ->orderBy('updated_at', 'DESC')
            ->get();
    }
}
