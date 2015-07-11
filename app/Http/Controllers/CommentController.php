<?php namespace Owl\Http\Controllers;

use Owl\Repositories\CommentRepositoryInterface;
use Owl\Repositories\ItemRepositoryInterface;
use Owl\Services\UserService;

class CommentController extends Controller
{
    protected $userService;
    protected $commentRepo;
    protected $itemRepo;
    private $status = 400;

    public function __construct(
        UserService $userService,
        CommentRepositoryInterface $commentRepo,
        ItemRepositoryInterface $itemRepo
    ) {
        $this->userService = $userService;
        $this->commentRepo = $commentRepo;
        $this->itemRepo = $itemRepo;
    }

    public function create()
    {
        $item = $this->itemRepo->getByOpenItemId(\Input::get('open_item_id'));
        $user = $this->userService->getCurrentUser();
        if (preg_match("/^[\s　\t\r\n]*$/s", \Input::get('body') || !$user || !$item)) {
            return "";
        }

        $object = app('stdClass');
        $object->item_id = $item->id;
        $object->user_id = $user->id;
        $object->body = \Input::get('body');
        $object->username = $user->username;
        $object->email = $user->email;
        $comment = $this->commentRepo->createComment($object);
        return \View::make('comment.body', compact('comment'));
    }

    public function update()
    {
        if (!$comment = $this->commentRepo->getCommentById(\Input::get('id'))) {
            return  \Response::make("", $this->status);
        }
        $comment = $this->commentRepo->updateComment($comment->id, \Input::get('body'));

        $needContainerDiv = false; //remove outer div for update js div replace
        return \View::make('comment.body', compact('comment', 'needContainerDiv'));

    }

    public function destroy()
    {
        if ($comment = $this->commentRepo->getCommentById(\Input::get('id'))) {
            $this->commentRepo->deleteComment($comment->id);
            $this->status = 200;
        }
        return  \Response::make("", $this->status);
    }
}
