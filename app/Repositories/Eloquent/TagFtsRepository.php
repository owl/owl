<?php namespace Owl\Repositories\Eloquent;

use Owl\Repositories\TagFtsRepositoryInterface;
use Owl\Repositories\Eloquent\Models\TagFts;
use Owl\Libraries\FtsUtils;

class TagFtsRepository implements TagFtsRepositoryInterface
{
    protected $tagFts;

    public function __construct(TagFts $tagFts)
    {
        $this->tagFts = $tagFts;
    }

    /**
     * get a tagFts data or Create a tagFts data by ID and Words.
     *
     * @param int $tag_id
     * @param string $words
     * @return Illuminate\Database\Eloquent\Model
     */
    public function firstOrCreateByIdAndWords($tag_id, $words)
    {
        return $this->tagFts->firstOrCreate(array('tag_id' => $tag_id, 'words' => $words));
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
