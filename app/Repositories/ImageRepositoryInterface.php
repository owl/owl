<?php namespace Owl\Repositories;

interface ImageRepositoryInterface
{
    /**
     * Create a new image.
     *
     * @param $image object alt_text, external_path, external_name
     * @return Illuminate\Database\Eloquent\Model
     */
    public function createImage($image);
}
