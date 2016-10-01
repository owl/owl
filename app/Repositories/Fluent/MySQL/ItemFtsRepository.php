<?php namespace Owl\Repositories\Fluent\MySQL;

use Owl\Repositories\ItemFtsRepositoryInterface;
use Owl\Libraries\FtsUtils;
use Owl\Repositories\Fluent\AbstractFluent;

class ItemFtsRepository extends AbstractFluent implements ItemFtsRepositoryInterface
{
    protected $table = 'items';

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
     * get a itemFts by item_id.
     *
     * @param int $item_id
     * @return void
     */
    public function getById($item_id)
    {
        return \DB::table($this->getTableName())
            ->where($this->getTableName().'.item_id', $item_id)
            ->first();
    }

    /**
     * Create a item fts.
     *
     * @param int $item_id
     * @param string $title
     * @param text $body
     * @return int
     */
    public function create($item_id, $title, $body)
    {
        return true;
    }

    /**
     * Convert String into N-Gramed string.
     *
     * @param string $title
     * @param text $body
     * @return string
     */
    public function toNgram($title, $body)
    {
        return FtsUtils::toNgram($title . "\n\n" . $body);
    }

    /**
     * Delete a item fts.
     *
     * @param $item_id int
     * @return boolean
     */
    public function deleteItemFts($item_id)
    {
        return true;
    }

    /**
     * match
     *
     * @param string $str
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function match($str, $limit = 10, $offset = 0)
    {
        return \DB::table($this->getTableName())
            ->join('users', 'items.user_id', '=', 'users.id')
            ->where('items.published', '2')
            ->whereRaw("match(items.title, items.body) against (? in boolean mode)", [$str])
            ->select(
                'items.title',
                'items.updated_at',
                'items.open_item_id',
                'users.email',
                'users.username'
            )
            ->orderBy('items.updated_at', 'desc')
            ->skip($offset)->take($limit)->get();
    }

    /**
     * matchCount
     *
     * @param string $str
     * @return array
     */
    public function matchCount($str)
    {
        return \DB::table($this->getTableName())
            ->join('users', 'items.user_id', '=', 'users.id')
            ->where('items.published', '2')
            ->whereRaw("match(items.title, items.body) against (? in boolean mode)", [$str])
            ->count();
    }

}
