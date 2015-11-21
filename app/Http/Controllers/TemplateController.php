<?php namespace Owl\Http\Controllers;

use Owl\Repositories\TemplateRepositoryInterface;
use Owl\Http\Requests\TemplateStoreRequest;
use Owl\Http\Requests\TemplateUpdateRequest;

class TemplateController extends Controller
{
    protected $templateRepo;

    public function __construct(TemplateRepositoryInterface $templateRepo)
    {
        $this->templateRepo = $templateRepo;
    }

    public function create()
    {
        return \View::make('templates.create');
    }

    public function store(TemplateStoreRequest $request)
    {
        $object = app('stdClass');
        $object->display_title = \Input::get('display_title');
        $object->title = \Input::get('title');
        $object->tags = \Input::get('tags');
        $object->body = \Input::get('body');
        $this->templateRepo->create($object);

        return \Redirect::to('/templates');
    }

    public function index()
    {
        $templates = $this->templateRepo->getAll();
        return \View::make('templates.index', compact('templates'));
    }

    public function show()
    {
        return \Redirect::to('/templates');
    }

    public function edit($templateId)
    {
        $template = $this->templateRepo->getById($templateId);
        if ($template == null) {
            \App::abort(404);
        }
        return \View::make('templates.edit', compact('template'));
    }

    public function update(TemplateUpdateRequest $request, $templateId)
    {
        $object = app('stdClass');
        $object->display_title = \Input::get('display_title');
        $object->title = \Input::get('title');
        $object->tags = \Input::get('tags');
        $object->body = htmlspecialchars(\Input::get('body'), ENT_QUOTES, 'UTF-8');
        $this->templateRepo->update($templateId, $object);

        return \Redirect::route('templates.index');
    }

    public function destroy($templateId)
    {
        $this->templateRepo->delete($templateId);
        return \Redirect::route('templates.index');
    }
}
