@extends('layouts.master')

@section('title')
タグ一覧 | Owl
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">タグ一覧</p>
@stop

@section('contents-main')

<div class="page-header">
    <h5>人気のタグ</h5>
</div>

<div class="tags">
    <ul class="list-group">
        @foreach ($tags as $tag)
        <li class="list-group-item">
            <span class="badge">{{ $tag->count }}</span>
            <p class="list-group-item-heading"><span class="tag-label"><a href="/tags/{{ $tag->name }}">{{ $tag->name }}</a></span></p>
            <p class="list-group-item-text">　<a href="/items/{{ $tag->open_item_id }}">{{ $tag->title }}</a></p>
        </li>
        @endforeach
    </ul>
</div>

@stop

@section('contents-sidebar')
    @include('layouts.contents-sidebar')
@stop
