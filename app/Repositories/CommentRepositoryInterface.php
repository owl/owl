<?php namespace Owl\Repositories;

interface CommentRepositoryInterface
{
    /**
     * Create a new comment.
     *
     * @param $comment object item_id, user_id, body, username, email
     * @return Illuminate\Database\Eloquent\Model
     */
    public function createComment($comment);

    /**
     * Update a comment's body.
     *
     * @param $id int
     * @param $body string
     * @return Illuminate\Database\Eloquent\Model
     */
    public function updateComment($id, $body);

    /**
     * Delete a comment.
     *
     * @param $id int
     * @return boolean
     */
    public function deleteComment($id);

    /**
     * Get a comment by comment id.
     *
     * @param $id int
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getCommentById($id);
}
