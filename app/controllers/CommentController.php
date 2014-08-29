<?php

class CommentController extends BaseController{


    public function create(){
        $item = Item::where('open_item_id',Input::get('open_item_id'))->first();
        $user = Sentry::findUserById(Input::get('user_id'));
        if(preg_match("/^[\s　\t\r\n]*$/s", Input::get('body') || !$user || !$item)) return "";
        $comment = new Comment;
        $comment->item_id = $item->id;
        $comment->user_id = Input::get('user_id');
        $comment->body = Input::get('body');
        $comment->save();
        $comment->user->username = $user->username;
        $comment->user->email = $user->email;
        return View::make('comment.body', compact('comment'));
    }

    public function update(){

    }

    public function destroy(){
        $comment = Comment::find(Input::get('id'));
        $comment->delete();
    }


}
