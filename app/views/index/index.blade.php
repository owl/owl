@extends('layouts.master')
@section('addCss')
{{HTML::style('css/style.css')}}
@stop
@include('layouts.header')
@section('content')
<body>

<h1>Athena</h1>

<h2>menu</h2>
<ul>
    <li><a href="/items/create">投稿する</a></li>
    <li><a href="/user/edit">ユーザ情報変更</a></li>
    <li><a href="/logout">ログアウト</a></li>
</ul>

<h2>user info</h2>
<ul>
    <li>user_id: {{$User->id}}</li>
    <li>email: {{$User->email}}</li>
</ul>

<h2>Items</h2>
@foreach ($items as $item)
    <a href="{{ action('ItemController@show', $item->id) }}">{{{ $item->title }}}</a> {{ $item->created_at }}<br />
@endforeach

@stop
@section('addJs')
@stop
@include('layouts.footer')
