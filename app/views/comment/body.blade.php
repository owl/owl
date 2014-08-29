<div class="media comment">
  <a class="pull-left" href="/{{{$comment->user->username}}}">
    {{ HTML::gravator($comment->user->email, 40,'mm','g','true',array('class'=>'media-object')) }}
  </a>
  <div class="media-body">
    <div class='left'>
      <div id="inside">
        <h4 class="media-heading" ><a class="pull-left" href="/{{{$comment->user->username}}}">{{$comment->user->username}}</a></h4>
      </div>
    </div>
    <div class="right">
      <div><?php echo date('Y/m/d H:i', strtotime($comment->updated_at)); ?></div>
      
      <div><a href="javascript:void(0)" class="start-edit">編集</a>・{{Form::hidden('comment_id', $comment->id, array('class'=>'comment-delete'))}}<a href="javascript:void(0)" class="comment-delete" value="anonakami">削除</a></div>
    </div>
  </div>
  <div class="body">
    <div class="arrow_box" style="">
    {{{$comment->body}}}
    </div>
  </div>
</div>
