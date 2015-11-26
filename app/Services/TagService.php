<?php namespace Owl\Services;

use Owl\Services\SearchService;
use Owl\Repositories\TagRepositoryInterface;
use Owl\Libraries\FtsUtils;

class TagService extends Service
{
    protected $searchService;
    protected $tagRepo;

    public function __construct(
        TagRepositoryInterface $tagRepo,
        SearchService $searchService
    ) {
        $this->tagRepo = $tagRepo;
        $this->searchService = $searchService;
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
     * get all flow tags.
     *
     * @return Collection
     */
    public function getAllFlowTags()
    {
        return $this->tagRepo->getAllFlowTags();
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
     * get a tag by tag id.
     *
     * @param int $id
     * @return void
     */
    public function getById($id)
    {
        return $this->tagRepo->getById($id);
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
            $this->searchService->tagFirstOrCreateByIdAndWords($tag['id'], FtsUtils::toNgram($tag_name));
            $tag_ids[] = (string)$tag['id'];
        }
        return $tag_ids;
    }

    /**
     * Update a tag's flow_flag.
     *
     * @param int $id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function updateFlowFlag($tag_id, $flag = true)
    {
        return $this->tagRepo->updateFlowFlag($tag_id, $flag);
    }

    /**
     * Delete a flow tag settings.
     *
     * @param $tag_id int tag_id
     * @return boolean
     */
    public function deleteFlowFlag($tag_id)
    {
        return $this->tagRepo->deleteFlowFlag($tag_id);
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
        $this->tagRepo->syncTags($item, $tag_ids);
    }
}
