<?php namespace Owl\Repositories\Eloquent;

use Owl\Repositories\TagRepositoryInterface;
use Owl\Repositories\Eloquent\Models\Tag;
use Owl\Repositories\Eloquent\Models\TagFts;

class TagRepository implements TagRepositoryInterface
{
    protected $tag;
    protected $tagFts;

    public function __construct(Tag $tag, TagFts $tagFts)
    {
        $this->tag = $tag;
        $this->tagFts = $tagFts;
    }

    /**
     * get all tags.
     *
     * @return Collection
     */
    public function getAll()
    {
        return $this->tag->all();
    }

    /**
     * get all used tags.
     *
     * @return array
     */
    public function getAllUsedTags()
    {
        $query = <<<__SQL__
            SELECT
                count(t.name) as count, t.id, t.name, it.item_id, i.title, i.open_item_id
            FROM
                tags as t
                LEFT JOIN
                    item_tag as it ON t.id = it.tag_id
                LEFT JOIN
                    items as i ON it.item_id = i.id
            WHERE
                i.published = 2
            GROUP BY
                t.id
            ORDER BY count DESC
__SQL__;
        return \DB::select($query);
    }

    /**
     * get a tag by tag name.
     *
     * @param string $name
     * @return void
     */
    public function getByName($name)
    {
        return $this->tag->where('name', $name)->first();
    }

    /**
     * get a tag or Create a tag.
     *
     * @param string $name
     * @return Illuminate\Database\Eloquent\Model
     */
    public function firstOrCreateByName($name)
    {
        return $this->tag->firstOrCreate(array('name' => $name))->toArray();
    }
}
