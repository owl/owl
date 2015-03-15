@extends('layouts.master')

@section ('addJs')
    <script type="text/javascript" language="JavaScript">
    function confirmDelete(t) {
        var answer = confirm("本当に削除しますか？");
        if (answer) {
            t.parentNode.submit()
        }
    }
    </script>
    <script src="{!! \HTML::cached_asset('js/stock.change.js') !!}"></script>
    <script src="{!! \HTML::cached_asset('js/like.change.js') !!}"></script>
    <script src="{!! \HTML::cached_asset('js/comment.create.js') !!}"></script>
@stop

@section('title')
    {{{$item->title}}} | Owl
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<div class="row">
    <div class="col-md-9">
        <h1 class="item-title">{{{ $item->title }}}</h1>
        {!! HTML::show_tags($item->tag->toArray()) !!}

        <div class="media">
            <a class="pull-left" href="#">
            {!! HTML::gravator($item->user->email, 40,'mm','g','true',array('class'=>'media-object')) !!}
            </a>
            <div class="media-body">
                <span class="item-manage"><p><a href="/{{{$item->user->username}}}" class="username">{{{$item->user->username}}}</a>さんが<?php echo date('Y/m/d', strtotime($item->updated_at)); ?>に投稿しました。{!! link_to_route('items.history','変更履歴',$item->open_item_id) !!}</p></span>
                @if(isset($User) && $item->user->id == $User->id)
                    {!! Form::open(['route'=>['items.destroy', $item->open_item_id], 'method'=>'DELETE']) !!}
                    {!! link_to_route('items.edit','編集',$item->open_item_id) !!}
                    <a onclick="confirmDelete(this);return false;" href="void()">削除</a>
                    {!! Form::close() !!}
                @elseif (isset($User))
                    {!! Form::open(['route'=>['items.destroy', $item->open_item_id], 'method'=>'DELETE']) !!}
                    {!! link_to_route('items.edit','編集',$item->open_item_id) !!}
                    {!! Form::close() !!}
                @endif

            </div>
        </div>
    </div>
    <div class="col-md-3">
        @if(isset($User))
            <div class="item-statuses">
                <div class="comment-status">
                    <span class="glyphicon glyphicon-comment"></span> {{{ count($item->comment) }}}<br />
                    コメント
                </div>
                <div class="stock-status">
                    <span class="glyphicon glyphicon-folder-close"></span> {{{ count($stocks) }}}<br />
                    ストック
                </div>
                <div class="like-status">
                    <span class="glyphicon glyphicon-thumbs-up"></span> {{{ count($like_users->like) }}}<br />
                    いいね！
                </div>
            </div>
            @if (count($stock) > 0)
            <div class="media-sidebar">
                <a href="javascript:void(0)" class="btn btn-default btn-block" id="unstock_id">ストックを解除する</a>
                <input type="hidden" value="{{{ $item->open_item_id }}}" id='open_id' />
            </div>
            @else
            <div class="media-sidebar">
                <a href="javascript:void(0)" class="btn btn-success btn-block" id="stock_id">この記事をストックする</a>
                <input type="hidden" value="{{{ $item->open_item_id }}}" id='open_id' />
            </div>
            @endif
        @endif
    </div>
</div>
@stop


@section('contents-main')
<?php if ($item->published === '0') : ?>
    <div class="alert alert-warning" role="alert">この記事は非公開設定です。投稿者本人のみアクセスできます。</div>
<?php elseif ($item->published === '1') : ?>
    <div class="alert alert-warning" role="alert">この記事は限定公開です。URLを知っている人のみアクセスすることができます。</div>
<?php endif; ?>

<div class="page-body">
{!! HTML::markdown($item->body) !!}
</div>

@if (isset($User))
    @if (count($like) > 0)
    <div class="like-area">
        <div class="like-area-button">
            <a href="javascript:void(0)" id="unlike_id" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-thumbs-up"></span> いいね！を取り消す</a><span id="like_count">{{ count($like_users->like) }}</span>人がいいね！と言っています。
        </div>
        <div class="like-area-icon">
            @foreach ($like_users->like as $like_user)
                {!! HTML::gravator($like_user->user->email, 20,'mm','g','true',array('class'=>'media-object', 'title' => $like_user->user->username)) !!}
            @endforeach
        </div>
    </div>
    @else
    <div class="like-area">
        <div class="like-area-button">
            <a href="javascript:void(0)" id="like_id" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-thumbs-up"></span> いいね！</a><span id="like_count">{{ count($like_users->like) }}</span>人がいいね！と言っています。
        </div>
        <div class="like-area-icon">
            @foreach ($like_users->like as $like_user)
                {!! HTML::gravator($like_user->user->email, 20,'mm','g','true',array('class'=>'media-object', 'title' => $like_user->user->username)) !!}
            @endforeach
        </div>
    </div>
    @endif
@endif
<div style='clear:both;'></div>

@if(isset($User))
    <div id="comment-container">
    <hr>
    @if (count($item->comment) >0)
        @foreach ($item->comment as $comment)
            @include('comment.body')
        @endforeach
    @endif
    </div>

    @include('comment.form')
@endif
@stop

@section('contents-sidebar')
    @include('layouts.items-show-sidebar')
@stop
