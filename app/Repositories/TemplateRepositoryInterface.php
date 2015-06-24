<?php namespace Owl\Repositories;

interface TemplateRepositoryInterface
{
    /**
     * Create a new template.
     *
     * @param $template object display_title, title, tags, body
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($template);

    /**
     * Get all template data.
     *
     * @return Illuminate\Database\Eloquent\Collection | Illuminate\Database\Eloquent\Builder
     */
    public function getAll();

    /**
     * Get template data by id.
     *
     * @param $template_id int template_id
     * @return Illuminate\Database\Eloquent\Collection | Illuminate\Database\Eloquent\Builder
     */
    public function getById($template_id);

    /**
     * Update a template data.
     *
     * @param $template_id int
     * @param $template object display_title, title, tags, body
     * @return Illuminate\Database\Eloquent\Model
     */
    public function update($template_id, $template);

    /**
     * Delete a tempalte data.
     *
     * @param $template_id int template_id
     * @return boolean
     */
    public function delete($template_id);
}
