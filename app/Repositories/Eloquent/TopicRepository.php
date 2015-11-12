<?php namespace Owl\Repositories\Eloquent;

use Owl\Repositories\TopicRepositoryInterface;
use Owl\Repositories\Eloquent\Models\Topic;

class TopicRepository implements TopicRepositoryInterface
{
    protected $topicRepo;

    public function __construct(Topic $topicRepo)
    {
        $this->topicRepo = $topicRepo;
    }

    public function getAll()
    {
        return $this->topicRepo->all();
    }

    public function create($object)
    {
        $topic = $this->topicRepo->newInstance();
        $topic->title = $object->title;
        $topic->body = $object->body;
        $topic->save();

        return $topic;
    }

    public function update($topic_id, $object)
    {
        $topic = $this->getById($topic_id);
        $topic->title = $object->title;
        $topic->body = $object->body;
        $topic->save();

        return $topic;
    }

    public function delete($topic_id)
    {
        return $this->topicRepo->where('id', $topic_id)->delete();
    }

    public function getById($topic_id)
    {
        return $this->topicRepo->find($topic_id);
    }
}
