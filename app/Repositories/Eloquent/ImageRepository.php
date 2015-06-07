<?php namespace Owl\Repositories\Eloquent;

use Owl\Repositories\ImageRepositoryInterface;
use Owl\Repositories\Eloquent\Models\Image;

class ImageRepository implements ImageRepositoryInterface
{
    protected $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    /**
     * Create a new image.
     *
     * @param $image object alt_text, external_path, external_name
     * @return Illuminate\Database\Eloquent\Model
     */
    public function createImage($img)
    {
        $image = $this->image->newInstance();
        $image->alt_text = $img->alt_text;
        $image->external_path = $img->external_path;
        $image->external_name = $img->external_name;
        $image->save();

        return $image;
    }
}
