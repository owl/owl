<?php namespace Owl\Repositories;

interface ItemFtsRepositoryInterface
{
    /**
     * Create a item fts.
     *
     * @param int $item_id
     * @param string $title
     * @param text $body
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($item_id, $title, $body);

    /**
     * Convert String into N-Gramed string.
     *
     * @param string $title
     * @param text $body
     * @return string
     */
    public function toNgram($title, $body);

    /**
     * Delete a item fts.
     *
     * @param $item_id int
     * @return boolean
     */
    public function deleteItemFts($item_id);

    /**
     * match
     *
     * @param string $str
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function match($str, $limit = 10, $offset = 0);

    /**
     * matchCount
     *
     * @param string $str
     * @return int $count
     */
    public function matchCount($str);
}
