<?php namespace Owl\Repositories;

interface TagFtsRepositoryInterface
{
    /**
     * get a tagFts data or Create a tagFts data by ID and Words.
     *
     * @param int $tag_id
     * @param string $words
     * @return Illuminate\Database\Eloquent\Model
     */
    public function firstOrCreateByIdAndWords($tag_id, $words);

    /**
     * get tags data by string for FullTextSearch.
     *
     * @param string $string
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function match($string, $limit = 10, $offset = 0);
}
