<?php namespace Owl\Http\Controllers;

use Owl\Repositories\LikeRepositoryInterface;
use Owl\Services\UserService;
use Owl\Services\ItemService;
use Owl\Services\LikeService;

class LikeController extends Controller
{
    protected $userService;
    protected $itemService;
    protected $likeService;

    public function __construct(
        UserService $userService,
        ItemService $itemService,
        LikeService $likeService
    ) {
        $this->userService = $userService;
        $this->itemService = $itemService;
        $this->likeService = $likeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return \Redirect::to('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $user = $this->userService->getCurrentUser();

        $openItemId = \Input::get('open_item_id');
        $item = $this->itemService->getByOpenItemId($openItemId);

        $this->likeService->firstOrCreate($user->id, $item->id);

        return \Response::json();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($openItemId)
    {
        $user = $this->userService->getCurrentUser();
        $item = $this->itemService->getByOpenItemId($openItemId);

        $this->likeService->delete($user->id, $item->id);
    }
}
