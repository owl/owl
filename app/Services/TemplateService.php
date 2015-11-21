<?php namespace Owl\Services;

use Owl\Repositories\TemplateRepositoryInterface;

class TemplateService extends Service
{
    protected $templateRepo;

    public function __construct(TemplateRepositoryInterface $templateRepo)
    {
        $this->templateRepo = $templateRepo;
    }

    /**
     * Create a new template.
     *
     * @param $template object display_title, title, tags, body
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($template)
    {
        return $this->templateRepo->create($template);
    }

    /**
     * Update a template data.
     *
     * @param $template_id int
     * @param $template object display_title, title, tags, body
     * @return Illuminate\Database\Eloquent\Model
     */
    public function update($template_id, $template)
    {
        return $this->templateRepo->update($template_id, $template);
    }

    /**
     * Delete a tempalte data.
     *
     * @param $template_id int template_id
     * @return boolean
     */
    public function delete($template_id)
    {
        return $this->templateRepo->delete($template_id);
    }

    /**
     * Get all template data.
     *
     * @return Illuminate\Database\Eloquent\Collection | Illuminate\Database\Eloquent\Builder
     */
    public function getAll()
    {
        return $this->templateRepo->getAll();
    }

    /**
     * Get template data by id.
     *
     * @param $template_id int template_id
     * @return Illuminate\Database\Eloquent\Collection | Illuminate\Database\Eloquent\Builder
     */
    public function getById($template_id)
    {
        return $this->templateRepo->getById($template_id);
    }
}
