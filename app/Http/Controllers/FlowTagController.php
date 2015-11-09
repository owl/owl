<?php namespace Owl\Http\Controllers;

use Owl\Services\TagService;
use Owl\Http\Requests\FlowTagStoreRequest;
use Owl\Http\Requests\FlowTagDestroyRequest;

class FlowTagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index()
    {
        $tags_info = $this->tagService->getAll();
        $tags = array();
        foreach ($tags_info as $tag_info) {
            $tags[$tag_info->id] = $tag_info->name;
        }

        $flow_tags = $this->tagService->getAllFlowTags();

        return \View::make('flow.index', compact('tags', 'flow_tags'));
    }

    public function store(FlowTagStoreRequest $request)
    {
        $this->tagService->updateFlowFlag($request->tag_id, $flag = true);

        $mes = 'フロータグを設定しました。';
        return redirect('manage/flow/index')->with('message', $mes);
    }

    public function destroy(FlowTagDestroyRequest $request)
    {
        $this->tagService->deleteFlowFlag($request->tag_id);
        $mes = 'フロータグを解除しました。';
        return redirect('manage/flow/index')->with('message', $mes);
    }
}
