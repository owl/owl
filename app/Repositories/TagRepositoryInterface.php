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
}
