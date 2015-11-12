<?php namespace Owl\Http\Controllers;

use Owl\Services\TopicService;
use Owl\Http\Requests\TopicStoreRequest;
use Owl\Http\Requests\TopicUpdateRequest;

class TopicController extends Controller
{
    protected $topicService;

    public function __construct(
        TopicService $topicService
    ) {
        $this->topicService = $topicService;
    }

    public function index()
    {
        $topics = $this->topicService->getAll();
        return \View::make('topics.index', compact('topics'));
    }

    public function create()
    {
        return \View::make('topics.create');
    }

    public function store(TopicStoreRequest $request)
    {
        $object = app('stdClass');
        $object->title = $request->input('title');
        $object->body = $request->input('body');
        $topic = $this->topicService->create($object);

        $topics = $this->topicService->getAll();
        return \View::make('topics.index', compact('topics'));
    }

    public function edit($topic_id)
    {
        $topic = $this->topicService->getById($topic_id);
        if ($topic === null) {
            \App::abort(404);
        }
        return \View::make('topics.edit', compact('topic'));
    }

    public function update(TopicUpdateRequest $request, $topic_id)
    {
        $topic = $this->topicService->getById($topic_id);
        if ($topic == null) {
            \App::abort(404);
        }

        $object = app('stdClass');
        $object->title = $request->input('title');
        $object->body = $request->input('body');
        $topic = $this->topicService->update($topic->id, $object);

        $topics = $this->topicService->getAll();
        return \View::make('topics.index', compact('topics'));
    }

    public function destroy($topic_id)
    {
        $topic = $this->topicService->getById($topic_id);
        if ($topic == null) {
            \App::abort(404);
        }
        $this->topicService->delete($topic_id);

        return \Redirect::route('topics.index');
    }

    public function show($topic_id)
    {
        $topic = $this->topicService->getById($topic_id);
        if ($topic == null) {
            \App::abort(404);
        }

        return \View::make('topics.show', compact('topic'));
    }
}
