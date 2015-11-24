<?php namespace Owl\Repositories\Eloquent;

use Owl\Repositories\TemplateRepositoryInterface;
use Owl\Repositories\Eloquent\Models\Template;

class TemplateRepository implements TemplateRepositoryInterface
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    /**
     * Create a new template.
     *
     * @param $template object display_title, title, tags, body
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($template)
    {
        $object = $this->template->newInstance();
        $object->fill(array(
            'display_title' => $template->display_title,
            'title' => $template->title,
            'tags' => $template->tags,
            'body' => $template->body,
        ));
        $object->save();

        return $object;
    }

    /**
     * Get all template data.
     *
     * @return Illuminate\Database\Eloquent\Collection | Illuminate\Database\Eloquent\Builder
     */
    public function getAll()
    {
        return $this->template->orderBy('id', 'asc')->get();
    }

    /**
     * Get template data by id.
     *
     * @param $template_id int template_id
     * @return Illuminate\Database\Eloquent\Collection | Illuminate\Database\Eloquent\Builder
     */
    public function getById($template_id)
    {
        return $this->template->where('id', $template_id)->first();
    }

    /**
     * Update a template data.
     *
     * @param $template_id int
     * @param $template object display_title, title, tags, body
     * @return Illuminate\Database\Eloquent\Model
     */
    public function updateTemplate($template_id, $template)
    {
        $object = $this->getById($template_id);
        if ($object == null) {
            \App::abort(404);
        }

        $object->fill(array(
            'display_title' => $template->display_title,
            'title'         => $template->title,
            'tags'          => $template->tags,
            'body'          => $template->body,
        ));
        $object->save();

        return $object;
    }

    /**
     * Delete a tempalte data.
     *
     * @param $template_id int template_id
     * @return boolean
     */
    public function delete($template_id)
    {
        return $this->template->where('id', $template_id)->delete();
    }
}
