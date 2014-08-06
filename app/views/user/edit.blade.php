@extends('layouts.master')

@section('title')
ユーザー情報変更 | Athena
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">ユーザー情報編集</p>
@stop

@section('contents-main')
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

@section('contents-sidebar')
    @include('layouts.contents-sidebar')
@stop
