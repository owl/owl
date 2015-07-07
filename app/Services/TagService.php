<?php namespace Owl\Services;

use Owl\Repositories\TagRepositoryInterface;
use Owl\Repositories\TagFtsRepositoryInterface;
use Owl\Libraries\FtsUtils;

class TagService extends Service
{
    protected $tagRepo;
    protected $tagFtsRepo;

    public function __construct(TagRepositoryInterface $tagRepo, TagFtsRepositoryInterface $tagFtsRepo)
    {
        $this->tagRepo = $tagRepo;
        $this->tagFtsRepo = $tagFtsRepo;
    }

    /**
     * get all tags.
     *
     * @return Collection
     */
    public function getAll()
    {
        return $this->tagRepo->getAll();
    }

    /**
     * get all used tags.
     *
     * @return array
     */
    public function getAllUsedTags()
    {
        return $this->tagRepo->getAllUsedTags();
    }

    /**
     * get a tag by tag name.
     *
     * @param string $name
     * @return void
     */
    public function getByName($name)
    {
        return $this->tagRepo->getByName($name);
    }

    /**
     * get tag ids by tag names.
     *
     * @param array $tag_names
     * @return array
     */
    public function getTagIdsByTagNames($tag_names)
    {
        $tag_ids = array();

        foreach ($tag_names as $tag_name) {
            $tag_name = trim(mb_convert_kana($tag_name, "&quot;s&quot;"));
            $tag_name = str_replace(" ", "", $tag_name);
            if (empty($tag_name)) {
                continue;
            }
            $tag_name = mb_strtolower($tag_name);
            $tag = $this->tagRepo->firstOrCreateByName($tag_name);
            $this->tagFtsRepo->firstOrCreateByIdAndWords($tag['id'], FtsUtils::toNgram($tag_name));
            $tag_ids[] = (string)$tag['id'];
        }
        return $tag_ids;
    }
}
