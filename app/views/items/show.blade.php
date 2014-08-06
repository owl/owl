@extends('layouts.master')

@section('title')
{{{$item->title}}} | Athena
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">{{{ $item->title }}}</p>
{{Form::open(['route'=>['items.destroy', $item->open_item_id], 'method'=>'DELETE'])}}
{{link_to_route('items.edit','編集',$item->open_item_id)}} 
<a onclick="this.parentNode.submit();return false;" href="void()">削除</a>
{{Form::close()}}
@stop

@section('contents-main')
<p>{{ $item->body }}</p>
<p>user_id: {{{ $item->user_id }}}</p>
<p>published: {{{ $item->published }}}</p>
@stop

@section('contents-sidebar')
    @include('layouts.contents-sidebar')
@stop
