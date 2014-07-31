@extends('layouts.master')
@section('addCss')
@stop
@include('layouts.header')
@section('content')
<body>

<h1>Athena</h1>

<h2>menu</h2>
<ul>
    <li><a href="/">{{{$User->username}}}</a></li>
    <li><a href="/items/create">投稿する</a></li>
    <li><a href="/logout">ログアウト</a></li>
</ul>

<h2>User detail</h2>
<h3>username: {{ $user->username }}</h3>
<p>user_id: {{{ $user->id }}}</p>
<p>email: {{{ $user->email }}}</p>
{{link_to_route('items.edit','編集する',$user->id)}}
{{Form::open(['route'=>['items.destroy', $user->id], 'method'=>'DELETE'])}}
<a onclick="this.parentNode.submit();return false;" href="void()">削除する</a>
{{Form::close()}}

@stop
@section('addJs')
@stop
@include('layouts.footer')
