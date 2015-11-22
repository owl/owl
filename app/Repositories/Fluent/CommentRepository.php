<?php namespace Owl\Repositories\Fluent;

use Owl\Repositories\CommentRepositoryInterface;

class CommentRepository extends AbstractFluent implements CommentRepositoryInterface
{
    protected $table = 'comments';

    /**
     * Get a table name.
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->table;
    }

    /**
     * Create a new comment.
     *
     * @param $comment object item_id, user_id, body, username, email
     * @return Illuminate\Database\Eloquent\Model
     */
    public function createComment($comment)
    {
        $object = array();
        $object["item_id"] = $comment->item_id;
        $object["user_id"] = $comment->user_id;
        $object["body"] = $comment->body;
        $comment_id = $this->insert($object);

        $ret = $this->getCommentById($comment_id);
        $user = app('stdClass');
        $user->username = $comment->username;
        $user->email = $comment->email;
        $ret->user = $user;

        return $ret;
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
        $object = array();
        $object["body"] = $body;
        $wkey["id"] = $id;
        $ret = $this->update($object, $wkey);

        $comment = $this->getCommentById($id);
        $comment->user = $this->getCommentUserById($id);
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
        $object = array();
        $wkey["id"] = $id;
        $ret = $this->delete($wkey);
        return $ret;
    }

    /**
     * Get a comment by comment id.
     *
     * @param $id int
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getCommentById($id)
    {
        return \DB::table($this->getTableName())
            ->where($this->getTableName().'.id', $id)
            ->first();
    }

    /**
     * Get a comment user by comment id.
     *
     * @param $id int
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getCommentUserById($id)
    {
        return \DB::table($this->getTableName())
            ->select('users.*')
            ->join('users', 'users.id', '=', $this->getTableName().'.user_id')
            ->where($this->getTableName().'.id', $id)
            ->first();
    }
}
