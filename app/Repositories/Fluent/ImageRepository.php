<?php namespace Owl\Repositories\Fluent;

use Owl\Repositories\ImageRepositoryInterface;

class ImageRepository extends AbstractFluent implements ImageRepositoryInterface
{
    protected $table = 'images';

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
     * Create a new image.
     *
     * @param $image object alt_text, external_path, external_name
     * @return Illuminate\Database\Eloquent\Model
     */
    public function createImage($image)
    {
        $object = array();
        $object["alt_text"] = $image->alt_text;
        $object["external_path"] = $image->external_path;
        $object["external_name"] = $image->external_name;
        $image_id = $this->insert($object);
        $ret = $this->getImageById($image_id);

        return $ret;
    }

    /**
     * Get a image by image id.
     *
     * @param $id int
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getImageById($id)
    {
        return \DB::table($this->getTableName())
            ->where($this->getTableName().'.id', $id)
            ->first();
    }
}
