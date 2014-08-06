@extends('layouts.master')

@section('title')
新規ユーザー登録 | Athena
@stop

@section('contents-pagehead')
<p class="page-title">新規ユーザー登録</p>
@stop

@section('contents-main')
    {{Form::open(array('url'=>'signup'))}}
        {{Form::text('username','',array('placeholder'=>'ユーザ名'))}}
        @if($errors->has('username'))
            {{$errors->first('username')}}
        @endif
        <br />
        {{Form::text('email','',array('placeholder'=>'Email'))}}
        @if($errors->has('email'))
            {{$errors->first('email')}}
        @endif
        <br />
        {{Form::password('password',array('placeholder'=>'パスワード'))}}
        @if($errors->has('password'))
            {{$errors->first('password')}}
        @endif
        <br />
        @if($errors->has('warning'))
            {{$errors->first('warning')}}<br />
        @endif
        {{Form::submit('登録')}}
    {{Form::close()}}
    <p><a href="/login">ログインはこちら</a></p>
@stop
