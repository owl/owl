<?php namespace Owl\Repositories\Eloquent;

use Owl\Repositories\ItemFtsRepositoryInterface;
use Owl\Repositories\Eloquent\Models\ItemFts;
use Owl\Libraries\FtsUtils;

class ItemFtsRepository implements ItemFtsRepositoryInterface
{
    protected $itemFts;

    public function __construct(ItemFts $itemFts)
    {
        $this->itemFts = $itemFts;
    }

    /**
     * Create a item fts.
     *
     * @param int $item_id
     * @param string $title
     * @param text $body
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($item_id, $title, $body)
    {
        $itemFts = $this->itemFts->newInstance();
        $itemFts->item_id = $item_id;
        $itemFts->words = $this->toNgram($title, $body);
        return $itemFts->save();
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
    public function delete($item_id)
    {
        return $this->itemFts->where('item_id', $item_id)->delete();
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
     * @return array
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
        return \DB::select(\DB::raw($query), array( 'match' => FtsUtils::createMatchWord($str)));
    }
}
