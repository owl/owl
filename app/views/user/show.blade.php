@extends('layouts.master')

@section('title')
{{ $user->username }} | Athena
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">{{ $user->username }}</p>
@stop

@section('contents-main')
    <p>user_id: {{{ $user->id }}}</p>
    <p>email: {{{ $user->email }}}</p>
    <?php if ($user->id == $User->id) : ?>
    {{Form::open(['route'=>['items.destroy', $user->id], 'method'=>'DELETE'])}}
    {{link_to_route('items.edit','編集',$user->id)}}
    <a onclick="this.parentNode.submit();return false;" href="void()">削除</a>
    {{Form::close()}}
    <?php endif; ?>
@stop

@section('contents-sidebar')
    @include('layouts.contents-sidebar')
@stop
