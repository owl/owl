<?php namespace Owl\Http\Controllers;

use Owl\Services\ImageService;

class ImageController extends Controller
{
    public $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function upload()
    {
        $image = $this->imageService->moveImage();
        $tag = $this->imageService->makeTag($image);

        return \View::make('image.add', compact('tag'));
    }
}
