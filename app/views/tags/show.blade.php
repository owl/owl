@extends('layouts.master')

@section('title')
すべての投稿 | Owl
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title"><span class="tag-title"><span class="glyphicon glyphicon-tags"></span> {{$tag->name}}</span>タグの記事</p>
@stop

@section('contents-main')
<div class="items">
    @foreach ($items as $item)
    <div class="item">
        {{ HTML::gravator($item->email, 40) }}
        <p><a href="/{{{$item->username}}}" class="username">{{{$item->username}}}</a>さんが<?php echo date('Y/m/d', strtotime($item->updated_at)); ?>に投稿しました。</p>
        <p><a href="{{ action('ItemController@show', $item->open_item_id) }}"><strong>{{{ $item->title }}}</strong></a></p>
    </div>
    @endforeach
</div>
@stop

@section('contents-sidebar')
@stop
