<?php namespace Owl\Repositories\Eloquent;

use Owl\Repositories\CommentRepositoryInterface;
use Owl\Repositories\Eloquent\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{
    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Create a new comment.
     *
     * @param $comment object item_id, user_id, body, username, email
     * @return Illuminate\Database\Eloquent\Model
     */
    public function createComment($cmt)
    {
        $comment = $this->comment->newInstance();
        $comment->item_id = $cmt->item_id;
        $comment->user_id = $cmt->user_id;
        $comment->body = $cmt->body;
        $comment->save();
        $comment->user->username = $cmt->username;
        $comment->user->email = $cmt->email;

        return $comment;
    }

    /**
     * Update a comment's body.
     *
     * @param $id int
     * @param $body string
     * @return Illuminate\Database\Eloquent\Model
     */
    public function updateComment($id, $body)
    {
        $comment = $this->getCommentById($id);
        $comment->body = $body;
        $comment->save();

        return $comment;
    }

    /**
     * Delete a comment.
     *
     * @param $id int
     * @return boolean
     */
    public function deleteComment($id)
    {
        $comment = $this->getCommentById($id);
        $comment->delete();

        return $comment;
    }

    /**
     * Get a comment by comment id.
     *
     * @param $id int
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getCommentById($id)
    {
        $comment = $this->comment->with('user')->find($id);
        if (!empty($comment)) {
            return $comment;
        }
        return false;
    }
}
