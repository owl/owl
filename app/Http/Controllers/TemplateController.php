<?php namespace Owl\Http\Controllers;

use Owl\Repositories\TemplateRepositoryInterface;

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

    public function store()
    {
        $valid_rule = array(
            'display_title' => 'required|max:255',
            'title' => 'required|max:255',
            'tags' => 'alpha_comma|max:64',
            'body' => 'required',
        );
        $validator = \Validator::make(\Input::all(), $valid_rule);

        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

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

    public function update($templateId)
    {
        $valid_rule = array(
            'display_title' => 'required|max:255',
            'title' => 'required|max:255',
            'tags' => 'alpha_comma|max:64',
            'body' => 'required',
        );
        $validator = \Validator::make(\Input::all(), $valid_rule);

        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

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
