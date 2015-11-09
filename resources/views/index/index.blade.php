@extends('layouts.master')

@section('title')
Owl | TOP
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">情報を共有しよう。</p>
@stop

@section('contents-main')
<ul class="nav nav-tabs nav-justified">
  <li role="presentation" class="active"><a href="#">ストック</a></li>
  <li role="presentation"><a href="#">フロー</a></li>
  <li role="presentation"><a href="#">全ての投稿</a></li>
</ul>

<div class="items">
    @foreach ($items as $item)
    <div class="item">
        {!! \HTML::gravator($item->user->email, 40) !!}
        <p><a href="/{{{$item->user->username}}}" class="username">{{{$item->user->username}}}</a>さんが<?php echo date('Y/m/d', strtotime($item->updated_at)); ?>に投稿しました。</p>
        <p><a href="{{ action('ItemController@show', $item->open_item_id) }}"><strong>{{{ $item->title }}}</strong></a></p>
    </div>
    @endforeach
<?php echo $items->render(); ?>
</div>
@stop

@section('contents-sidebar')
    @include('layouts.contents-sidebar')
@stop
