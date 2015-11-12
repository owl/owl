<?php namespace Owl\Repositories;

interface TopicRepositoryInterface
{
    public function getAll();

    public function create($object);

    public function update($topic_id, $object);

    public function delete($topic_id);

    public function getById($topic_id);
}
