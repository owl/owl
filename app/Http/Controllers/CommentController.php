<?php namespace Owl\Http\Controllers;

//use Owl\Repositories\Eloquent\CommentRepository;
use Owl\Repositories\CommentRepositoryInterface;
use Owl\Models\Item;
use Owl\Services\UserService;

class CommentController extends Controller
{
    protected $userService;
    protected $commentRepo;
    private $status = 400;

    public function __construct(UserService $userService, CommentRepositoryInterface $commentRepo)
    {
        $this->userService = $userService;
        $this->commentRepo = $commentRepo;
    }

    public function create()
    {
        $item = Item::where('open_item_id', \Input::get('open_item_id'))->first();
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
