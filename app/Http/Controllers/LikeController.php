<?php namespace Owl\Http\Controllers;

use Owl\Repositories\LikeRepositoryInterface;
use Owl\Repositories\ItemRepositoryInterface;
use Owl\Services\UserService;

class LikeController extends Controller
{
    protected $userService;
    protected $likeRepo;
    protected $itemRepo;

    public function __construct(
        UserService $userService,
        LikeRepositoryInterface $likeRepo,
        ItemRepositoryInterface $itemRepo
    ) {
        $this->userService = $userService;
        $this->likeRepo = $likeRepo;
        $this->itemRepo = $itemRepo;
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
        $item = $this->itemRepo->getByOpenItemId($openItemId);

        $this->likeRepo->firstOrCreate($user->id, $item->id);

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
        $item = $this->itemRepo->getByOpenItemId($openItemId);

        $this->likeRepo->delete($user->id, $item->id);
    }
}
