<?php namespace Owl\Repositories\Fluent;

use Owl\Repositories\TagFtsRepositoryInterface;
use Owl\Libraries\FtsUtils;

class TagFtsRepository extends AbstractFluent implements TagFtsRepositoryInterface
{
    protected $table = 'tags_fts';

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
     * @return stdClass
     */
    public function firstOrCreateByIdAndWords($tag_id, $words)
    {
        $tagFtsData = \DB::table($this->getTableName())
            ->where('tag_id', $tag_id)
            ->where('words', $words)
            ->first();

        if (!empty($tagFtsData)) {
            $ret = array();
            $ret["tag_id"] = $tagFtsData->tag_id;
            $ret["words"] = $tagFtsData->words;
            return $ret;
        }

        $object = array();
        $object["tag_id"] = $tag_id;
        $object["words"] = $words;
        \DB::table($this->getTableName())->insertGetId($object);

        $tagFtsData = $this->getById($tag_id);
        $ret = array();
        $ret["tag_id"] = $tagFtsData->tag_id;
        $ret["words"] = $tagFtsData->words;
        return $ret;
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
        $query = <<<__SQL__
            SELECT
              ta.name
            FROM
              tags_fts fts 
            INNER JOIN
              tags ta ON ta.id = fts.tag_id
            WHERE
              fts.words MATCH :match
            ORDER BY
              ta.updated_at DESC
            LIMIT 
              $limit 
            OFFSET
              $offset 
__SQL__;
        return \DB::select(\DB::raw($query), array( 'match' => FtsUtils::createMatchWord($str)));
    }
}
