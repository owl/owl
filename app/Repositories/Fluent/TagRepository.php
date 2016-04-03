<?php namespace Owl\Repositories\Fluent;

use Owl\Repositories\TagRepositoryInterface;

class TagRepository extends AbstractFluent implements TagRepositoryInterface
{
    const FLOW_FLAG_ON = 1;
    const FLOW_FLAG_OFF = 0;

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
     * get all tags.
     *
     * @return Collection
     */
    public function getAll()
    {
        return \DB::table($this->getTableName())->get();
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
        return \DB::table($this->getTableName())
            ->where($this->getTableName().'.name', $name)
            ->first();
    }

    /**
     * get a tag or Create a tag.
     *
     * @param string $name
     * @return Illuminate\Database\Eloquent\Model
     */
    public function firstOrCreateByName($name)
    {
        $tagData = \DB::table($this->getTableName())
            ->where($this->getTableName().'.name', $name)
            ->first();

        if (!empty($tagData)) {
            $ret = array();
            $ret["id"] = $tagData->id;
            $ret["name"] = $tagData->name;
            $ret["created_at"] = $tagData->created_at;
            $ret["updated_at"] = $tagData->updated_at;
            $ret["flow_flag"] = $tagData->flow_flag;
            return $ret;
        }

        $object = array();
        $object["name"] = $name;
        $tag_id = $this->insert($object);

        $tagData =  $this->getById($tag_id);
        $ret = array();
        $ret["id"] = $tagData->id;
        $ret["name"] = $tagData->name;
        $ret["created_at"] = $tagData->created_at;
        $ret["updated_at"] = $tagData->updated_at;
        $ret["flow_flag"] = $tagData->flow_flag;
        return $ret;
    }

    /**
     * get all flow tags.
     *
     * @return Collection
     */
    public function getAllFlowTags()
    {
        return \DB::table($this->getTableName())
            ->where($this->getTableName().'.flow_flag', self::FLOW_FLAG_ON)
            ->get();
    }

    /**
     * get a tag by tag id.
     *
     * @param int $id
     * @return void
     */
    public function getById($id)
    {
        return \DB::table($this->getTableName())
            ->where($this->getTableName().'.id', $id)
            ->first();
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

        $object = array();
        $object["flow_flag"] = $flow;
        $wkey["id"] = $tag_id;
        $ret = $this->update($object, $wkey);
        return $this->getById($tag_id);
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

        $object = array();
        $object["flow_flag"] = self::FLOW_FLAG_OFF;
        $wkey["id"] = $tag_id;
        $ret = $this->update($object, $wkey);
        return $this->getById($tag_id);
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
        // item_idに紐づくcurrent_tag_idsを取得
        $current_tag_ids_raw = $this->getByItemId($item->id);
        $current_tag_ids = array();
        foreach ($current_tag_ids_raw as $current_tag) {
            $current_tag_ids[] = (string)$current_tag->tag_id;
        }

        // attachとdetachするtag_idを取得
        $new_tags = array_merge(array_diff($tag_ids, $current_tag_ids), array());
        $delete_tags = array_merge(array_diff($current_tag_ids, $tag_ids), array());

        $this->attachTags($item->id, $new_tags);
        $this->detachTags($item->id, $delete_tags);
    }

    /**
     * get tags by item_id.
     *
     * @param int $item_id
     * @return void
     */
    public function getByItemId($item_id)
    {
        return \DB::table('item_tag')
            ->select('tag_id')
            ->where('item_id', $item_id)
            ->get();
    }

    /**
     * attach tags
     *
     * @param int $item_id
     * @param array $tag_ids
     * @return stdClass
     */
    public function attachTags($item_id, $tag_ids)
    {
        $ids = array();
        foreach ($tag_ids as $tag_id) {
            $params = array();
            $params["item_id"] = $item_id;
            $params["tag_id"] = $tag_id;
            $ids[] = \DB::table("item_tag")->insertGetId($params);
        }
        return $ids;
    }

    /**
     * detach tags
     *
     * @param int $item_id
     * @param array $tag_ids
     * @return stdClass
     */
    public function detachTags($item_id, $tag_ids)
    {
        $ids = array();
        foreach ($tag_ids as $tag_id) {
            $ids[] = \DB::table("item_tag")
                ->where("item_id", '=', $item_id)
                ->where("tag_id", '=', $tag_id)
                ->delete();
        }
        return $ids;
    }
}
