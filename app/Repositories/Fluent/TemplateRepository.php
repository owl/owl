<?php namespace Owl\Repositories\Fluent;

use Owl\Repositories\TemplateRepositoryInterface;

class TemplateRepository extends AbstractFluent implements TemplateRepositoryInterface
{
    protected $table = 'templates';

    /**
     * Get a table name.
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->table;
    }

    /**
     * Get template data by id.
     *
     * @param $template_id int template_id
     * @return stdClass
     */
    public function getById($template_id)
    {
        return \DB::table($this->getTableName())
            ->where($this->getTableName().'.id', $template_id)
            ->first();
    }

    /**
     * Create a new template.
     *
     * @param $template object display_title, title, tags, body
     * @return stdClass
     */
    public function create($template)
    {
        $object = array();
        $object["display_title"] = $template->display_title;
        $object["title"] = $template->title;
        $object["tags"] = $template->tags;
        $object["body"] = $template->body;
        $template_id = $this->insert($object);

        $ret = $this->getById($template_id);

        return $ret;
    }

    /**
     * Get all template data.
     *
     * @return stdClass
     */
    public function getAll()
    {
        return \DB::table($this->getTableName())
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * Update a template data.
     *
     * @param $template_id int
     * @param $template object display_title, title, tags, body
     * @return stdClass
     */
    public function updateTemplate($template_id, $template)
    {
        $ret = $this->getById($template_id);
        if ($ret == null) {
            \App::abort(404);
        }

        $object = array();
        $object["display_title"] = $template->display_title;
        $object["title"] = $template->title;
        $object["tags"] = $template->tags;
        $object["body"] = $template->body;
        $wkey["id"] = $template_id;
        $ret = $this->update($object, $wkey);

        $template = $this->getById($template_id);
        return $template;
    }


    /**
     * Delete a tempalte data.
     *
     * @param $template_id int template_id
     * @return boolean
     */
    public function destroy($template_id)
    {
        $object = array();
        $wkey["id"] = $template_id;
        $ret = $this->delete($wkey);
        return $ret;
    }
}
