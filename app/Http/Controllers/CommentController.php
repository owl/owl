<?php namespace Owl\Http\Controllers;

use Owl\Services\UserService;
use Owl\Services\ItemService;
use Owl\Services\CommentService;

class CommentController extends Controller
{
    protected $userService;
    protected $itemService;
    protected $commentService;
    private $status = 400;

    public function __construct(
        UserService $userService,
        ItemService $itemService,
        CommentService $commentService
    ) {
        $this->userService = $userService;
        $this->itemService = $itemService;
        $this->commentService = $commentService;
    }

    public function create()
    {
        $item = $this->itemService->getByOpenItemId(\Input::get('open_item_id'));
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
        $comment = $this->commentService->createComment($object);
        return \View::make('comment.body', compact('comment'));
    }

    public function update()
    {
        if (!$comment = $this->commentService->getCommentById(\Input::get('id'))) {
            return  \Response::make("", $this->status);
        }
        $comment = $this->commentService->updateComment($comment->id, \Input::get('body'));

        $needContainerDiv = false; //remove outer div for update js div replace
        return \View::make('comment.body', compact('comment', 'needContainerDiv'));

    }

    public function destroy()
    {
        if ($comment = $this->commentService->getCommentById(\Input::get('id'))) {
            $this->commentService->deleteComment($comment->id);
            $this->status = 200;
        }
        return  \Response::make("", $this->status);
    }
}
