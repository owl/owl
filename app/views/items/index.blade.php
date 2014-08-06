@extends('layouts.master')

@section('title')
編集 | Athena
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-main')
    <h4>すべての投稿</h4>
    @foreach ($items as $item)
        <a href="{{ action('ItemController@show', $item->open_item_id) }}">{{{ $item->title }}}</a> {{ $item->created_at }}<br />
    @endforeach
@stop

@section('contents-sidebar')
    @include('layouts.contents-sidebar')
@stop
