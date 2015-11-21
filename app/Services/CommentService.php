<?php namespace Owl\Services;

use Owl\Repositories\CommentRepositoryInterface;

class CommentService extends Service
{
    protected $commentRepo;

    public function __construct(
        CommentRepositoryInterface $commentRepo
    ) {
        $this->commentRepo = $commentRepo;
    }

    /**
     * Create a new comment.
     *
     * @param $comment object item_id, user_id, body, username, email
     * @return Illuminate\Database\Eloquent\Model
     */
    public function createComment($cmt)
    {
        return $this->commentRepo->createComment($cmt);
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
        return $this->commentRepo->updateComment($id, $body);
    }

    /**
     * Delete a comment.
     *
     * @param $id int
     * @return boolean
     */
    public function deleteComment($id)
    {
        return $this->commentRepo->deleteComment($id);
    }

    /**
     * Get a comment by comment id.
     *
     * @param $id int
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getCommentById($id)
    {
        return $this->commentRepo->getCommentById($id);
    }
}
