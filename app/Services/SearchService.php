<?php namespace Owl\Services;

use Owl\Repositories\ItemFtsRepositoryInterface;
use Owl\Repositories\TagFtsRepositoryInterface;

class SearchService extends Service
{
    protected $itemFtsRepo;
    protected $tagFtsRepo;

    public function __construct(
        ItemFtsRepositoryInterface $itemFtsRepo,
        TagFtsRepositoryInterface $tagFtsRepo
    ) {
        $this->itemFtsRepo = $itemFtsRepo;
        $this->tagFtsRepo = $tagFtsRepo;
    }

    /**
     * item match
     *
     * @param string $str
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function itemMatch($str, $limit = 10, $offset = 0)
    {
        return $this->itemFtsRepo->match($str, $limit, $offset);
    }

    /**
     * item matchCount
     *
     * @param string $str
     * @return array
     */
    public function itemMatchCount($str)
    {
        return $this->itemFtsRepo->matchCount($str);
    }

    /**
     * Delete a item fts.
     *
     * @param $item_id int
     * @return boolean
     */
    public function itemDelete($item_id)
    {
        return $this->itemFtsRepo->deleteItemFts($item_id);
    }

    /**
     * Create a item fts.
     *
     * @param int $item_id
     * @param string $title
     * @param text $body
     * @return Illuminate\Database\Eloquent\Model
     */
    public function itemCreate($item_id, $title, $body)
    {
        return $this->itemFtsRepo->create($item_id, $title, $body);
    }

    /**
     * get tags data by string for FullTextSearch.
     *
     * @param string $string
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function tagMatch($str, $limit = 10, $offset = 0)
    {
        return $this->tagFtsRepo->match($str, $limit, $offset);
    }

    /**
     * get a tagFts data or Create a tagFts data by ID and Words.
     *
     * @param int $tag_id
     * @param string $words
     * @return Illuminate\Database\Eloquent\Model
     */
    public function tagFirstOrCreateByIdAndWords($tag_id, $words)
    {
        return $this->tagFtsRepo->firstOrCreateByIdAndWords($tag_id, $words);
    }
}
