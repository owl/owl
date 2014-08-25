@extends('layouts.master')

@section ('addJs')
{{HTML::script("/js/stock.change.js")}}
{{HTML::script("/js/like.change.js")}}
{{HTML::script("/js/comment.create.js")}}
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
    <div class="media">
        <a class="pull-left" href="#">
        {{ HTML::gravator($item->user->email, 60,'mm','g','true',array('class'=>'media-object')) }}
        </a>
        <div class="media-body">
            <p class="item-title">{{{ $item->title }}}</p>
            <p><a href="/{{{$item->user->username}}}" class="username">{{{$item->user->username}}}</a>さんが<?php echo date('Y/m/d', strtotime($item->updated_at)); ?>に投稿しました。</p>

            <?php if ($item->user->id == $User->id) : ?>
            {{Form::open(['route'=>['items.destroy', $item->open_item_id], 'method'=>'DELETE'])}}
            {{link_to_route('items.edit','編集',$item->open_item_id)}} 
            <a onclick="confirm('本当に削除しますか？'); this.parentNode.submit();return false;" href="void()">削除</a>
            {{Form::close()}}
            <?php endif; ?>
        </div>
    </div>
    </div>
    <div class="col-md-3">
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
    </div>
</div>
@stop


@section('contents-main')
<?php if ($item->published === '0') : ?>
    <div class="alert alert-warning" role="alert">この記事は非公開設定です。投稿者本人のみアクセスできます。</div>
<?php elseif ($item->published === '1') : ?>
    <div class="alert alert-warning" role="alert">この記事は限定公開です。URLを知っている人のみアクセスすることができます。</div>
<?php endif; ?>

<p class="page-body">{{ $item->body }}</p>


@if (count($like) > 0)
    <a href="javascript:void(0)" id="unlike_id" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-thumbs-up"></span> いいね！を取り消す</a>
@else
    <a href="javascript:void(0)" id="like_id" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-thumbs-up"></span> いいね！</a>
@endif

<div id="comment_container">
@if (count($item->comment) >0)
    @foreach ($item->comment as $comment)
        @include('comment.body')
    @endforeach
@endif
</div>

@include('comment.form')

@stop

@section('contents-sidebar')
    @include('layouts.contents-sidebar')
@stop
