<?php namespace Owl\Services;

use Owl\Repositories\TopicRepositoryInterface;

class TopicService extends Service
{
    protected $topicRepo;

    public function __construct(
        TopicRepositoryInterface $topicRepo
    ) {
        $this->topicRepo = $topicRepo;
    }

    public function getAll()
    {
        return $this->topicRepo->getAll();
    }

    public function getAllWithPaginate()
    {
        return $this->topicRepo->getAllWithPaginate();
    }

    public function create($object)
    {
        $topic = $this->topicRepo->create($object);
        return $topic;
    }

    public function update($topic_id, $object)
    {
        $topic = $this->topicRepo->update($topic_id, $object);

        return $topic;
    }

    public function delete($topic_id)
    {
        return $this->topicRepo->delete($topic_id);
    }

    public function getById($topic_id)
    {
        return $this->topicRepo->getById($topic_id);
    }
}
