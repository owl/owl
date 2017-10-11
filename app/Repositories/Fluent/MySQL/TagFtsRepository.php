<?php namespace Owl\Repositories\Fluent\MySQL;

use Owl\Repositories\TagFtsRepositoryInterface;
use Owl\Libraries\FtsUtils;
use Owl\Repositories\Fluent\AbstractFluent;

class TagFtsRepository extends AbstractFluent implements TagFtsRepositoryInterface
{
    protected $table = 'tags';

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
     * get a tagFts data or Create a tagFts data by ID and Words.
     *
     * @param int $tag_id
     * @param string $words
     * @return array
     */
    public function firstOrCreateByIdAndWords($tag_id, $words)
    {
        return array();
    }

    /**
     * get a tagFts by tag_id.
     *
     * @param int $id
     * @return void
     */
    public function getById($tag_id)
    {
        return \DB::table($this->getTableName())
            ->where($this->getTableName().'.tag_id', $tag_id)
            ->first();
    }

    /**
     * get tags data by string for FullTextSearch.
     *
     * @param string $string
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function match($str, $limit = 10, $offset = 0)
    {
        return \DB::table($this->getTableName())
            ->whereRaw("match(tags.name) against (? in boolean mode)", [$str])
            ->select(
                'tags.name'
            )
            ->orderBy('tags.updated_at', 'desc')
            ->skip($offset)->take($limit)->get();
    }
}
