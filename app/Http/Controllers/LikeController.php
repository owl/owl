<?php namespace Owl\Http\Controllers;

use Illuminate\Contracts\Events\Dispatcher;
use Owl\Services\UserService;
use Owl\Services\ItemService;
use Owl\Services\LikeService;
use Owl\Events\Item\LikeEvent;

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
     * @param Dispatcher  $event
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Dispatcher $event)
    {
        $user = $this->userService->getCurrentUser();

        $openItemId = \Input::get('open_item_id');
        $item = $this->itemService->getByOpenItemId($openItemId);

        $this->likeService->firstOrCreate($user->id, $item->id);

        // fire Like Event
        // TODO: do not generate instance in controller method
        $event->fire(new LikeEvent(
            $openItemId,
            (int) $user->id
        ));

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
