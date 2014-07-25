@extends('layouts.master')
@section('addCss')
@stop
@include('layouts.header')
@section('content')
<body>

<h1>Athena</h1>

<h2>menu</h2>
<ul>
    <li><a href="/items/create">投稿する</a></li>
    <li><a href="/logout">ログアウト</a></li>
</ul>

<h2>Item detail</h2>
<h3>title: {{{ $item->title }}}</h3>
<p>user_id: {{{ $item->user_id }}}</p>
<p>body: {{{ $item->body }}}</p>
<p>published: {{{ $item->published }}}</p>

@stop
@section('addJs')
@stop
@include('layouts.footer')
