@extends('layouts.master')

@section('title')
{{{$item->title}}} | Owl
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')

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
@stop


@section('contents-main')
<?php if ($item->published === '0') : ?>
    <div class="alert alert-warning" role="alert">この記事は非公開設定です。投稿者本人のみアクセスできます。</div>
<?php elseif ($item->published === '1') : ?>
    <div class="alert alert-warning" role="alert">この記事は限定公開です。URLを知っている人のみアクセスすることができます。</div>
<?php endif; ?>

<p class="page-body">{{ $item->body }}</p>
@stop

@section('contents-sidebar')
    @include('layouts.contents-sidebar')
@stop
