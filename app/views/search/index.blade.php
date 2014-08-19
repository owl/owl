@extends('layouts.master')

@section('title')
{{$q}}の検索結果 | Owl
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title"><span class='search-word'>{{$q}}</span>の検索結果</p>
@stop

@section('contents-main')
    @if (count($results) > 0)
    <div class="items">
    @foreach ($results as $item)
    <div class="item">
        <a class="pull-left" href="/{{$item->username}}">
            {{ HTML::gravator($item->email, 40) }}
        </a>
        <div class="media-body">
            <p><a href="/{{{$item->username}}}" class="username">{{{$item->username}}}</a>さんが<?php echo date('Y/m/d', strtotime($item->updated_at)); ?>に投稿しました。</p>
            <p><a href="{{ action('ItemController@show', $item->open_item_id) }}"><strong>{{{ $item->title }}}</strong></a></p>
        </div>
    </div>
    @endforeach
    <?php echo $pagination->appends(array('q' => $q))->links(); ?>
    </div>
    @else
    <div class="noresults">
    検索結果は見つかりませんでした。クエリを変えて再度検索して下さい。
    </div> 
    @endif
@stop

@section('contents-sidebar')
    @include('layouts.contents-sidebar')
@stop
