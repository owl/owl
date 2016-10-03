<?php namespace Owl\Repositories\Fluent;

use Owl\Repositories\ItemFtsRepositoryInterface;
use Owl\Libraries\FtsUtils;

class ItemFtsRepository extends AbstractFluent implements ItemFtsRepositoryInterface
{
    protected $table = 'items_fts';

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
        $object = array();
        $object["item_id"] = $item_id;
        $object["words"] = $this->toNgram($title, $body);
        \DB::table($this->getTableName())->insertGetId($object);

        return $item_id;
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
        $object = array();
        $wkey["item_id"] = $item_id;
        $ret = $this->delete($wkey);
        return $ret;
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
        $query = <<<__SQL__
            SELECT
              it.title,
              it.updated_at,
              it.open_item_id,
              us.email,
              us.username
            FROM
              items_fts fts 
            INNER JOIN
              items it ON it.id = fts.item_id AND it.published = 2
            INNER JOIN
              users us ON it.user_id = us.id
            WHERE
              fts.words MATCH :match
            ORDER BY
              it.updated_at DESC, it.id DESC
            LIMIT 
              $limit 
            OFFSET
              $offset 
__SQL__;
        return \DB::select(\DB::raw($query), array( 'match' => FtsUtils::createMatchWord($str)));
    }

    /**
     * matchCount
     *
     * @param string $str
     * @return int $count
     */
    public function matchCount($str)
    {
        $query = <<<__SQL__
            SELECT
              COUNT(*) as count
            FROM
              items_fts fts 
            INNER JOIN
              items it ON it.id = fts.item_id AND it.published = 2
            WHERE
              fts.words MATCH :match
__SQL__;
        $res = \DB::select(\DB::raw($query), array( 'match' => FtsUtils::createMatchWord($str)));
        return $res[0]->count;
    }
}
