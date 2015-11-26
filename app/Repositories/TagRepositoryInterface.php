<?php namespace Owl\Repositories;

interface TagRepositoryInterface
{
    /**
     * get all tags.
     *
     * @return Collection
     */
    public function getAll();

    /**
     * get all used tags.
     *
     * @return array
     */
    public function getAllUsedTags();

    /**
     * get a tag by tag name.
     *
     * @param string $name
     * @return void
     */
    public function getByName($name);

    /**
     * get a tag or Create a tag.
     *
     * @param string $name
     * @return Illuminate\Database\Eloquent\Model
     */
    public function firstOrCreateByName($name);

    /**
     * get all flow tags.
     *
     * @return Collection
     */
    public function getAllFlowTags();

    /**
     * get a tag by tag id.
     *
     * @param int $id
     * @return void
     */
    public function getById($id);

    /**
     * Update a tag's flow_flag.
     *
     * @param int $tag_id
     * @param boolean $flag
     * @return Illuminate\Database\Eloquent\Model
     */
    public function updateFlowFlag($tag_id, $flag = true);

    /**
     * Delete a flow tag settings.
     *
     * @param $tag_id int tag_id
     * @return boolean
     */
    public function deleteFlowFlag($tag_id);

    /**
     * sync tags
     *
     * @param object $item
     * @param array $tag_ids
     * @return void
     */
    public function syncTags($item, $tag_ids);
}
