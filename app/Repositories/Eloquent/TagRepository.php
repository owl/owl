<?php namespace Owl\Repositories\Eloquent;

use Owl\Repositories\TagRepositoryInterface;
use Owl\Repositories\Eloquent\Models\Tag;
use Owl\Repositories\Eloquent\Models\TagFts;

class TagRepository implements TagRepositoryInterface
{
    const FLOW_FLAG_ON = 1;
    const FLOW_FLAG_OFF = 0;

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
     * get all flow tags.
     *
     * @return Collection
     */
    public function getAllFlowTags()
    {
        return $this->tag->where('flow_flag', self::FLOW_FLAG_ON)->get();
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
     * @return Collection
     */
    public function getByName($name)
    {
        return $this->tag->where('name', $name)->first();
    }

    /**
     * get a tag by tag id.
     *
     * @param int $id
     * @return Collection
     */
    public function getById($id)
    {
        return $this->tag->where('id', $id)->first();
    }

    /**
     * get tags by item_id.
     *
     * @param int $item_id
     * @return Collection
     */
    public function getByItemId($item_id)
    {
        return \DB::table('item_tag')
            ->where('item_id', $item_id)
            ->get();
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

    /**
     * Update a tag's flow_flag.
     *
     * @param int $tag_id
     * @param boolean $flag
     * @return Illuminate\Database\Eloquent\Model
     */
    public function updateFlowFlag($tag_id, $flag = true)
    {
        $tag = $this->getById($tag_id);
        if (!$tag) {
            return false;
        }
        $flow = ($flag) ? self::FLOW_FLAG_ON : self::FLOW_FLAG_OFF;

        $tag->flow_flag = $flow;

        if ($tag->save()) {
            return $tag;
        } else {
            return false;
        }
    }

    /**
     * Delete a flow tag settings.
     *
     * @param $tag_id int tag_id
     * @return boolean
     */
    public function deleteFlowFlag($tag_id)
    {
        $tag = $this->getById($tag_id);
        if (!$tag) {
            return false;
        }
        $tag->flow_flag = self::FLOW_FLAG_OFF;

        if ($tag->save()) {
            return $tag;
        } else {
            return false;
        }
    }

    /**
     * sync tags
     *
     * @param object $item
     * @param array $tag_ids
     * @return void
     */
    public function syncTags($item, $tag_ids)
    {
        $item->tag()->sync($tag_ids);
    }
}
