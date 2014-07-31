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
    <li><a href="/logout">ログアウト</a></li>
</ul>

<h2>User Edit</h2>
@if(Session::has('status'))
{{Session::get('status')}}<br />
@endif
{{Form::open(array('url'=>'user/edit', 'method'=>'PUT'))}}
    {{Form::text('username',$User->username,array('placeholder'=>'ユーザ名'))}}
    @if($errors->has('username'))
        {{$errors->first('username')}}
    @endif
    <br />
    {{Form::text('email',$User->email,array('placeholder'=>'Email'))}}
    @if($errors->has('email'))
        {{$errors->first('email')}}
    @endif
    <br />
    @if($errors->has('warning'))
        {{$errors->first('warning')}}<br />
    @endif
    {{Form::submit('登録')}}
{{Form::close()}}

@stop
@section('addJs')
@stop
@include('layouts.footer')
