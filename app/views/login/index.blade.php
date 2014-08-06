@extends('layouts.master')

@section('title')
ログイン | Athena
@stop

@section('contents-pagehead')
<p class="page-title">ログイン</p>
@stop

@section('contents-main')
    {{Form::open(array('url'=>'login'))}}
    @if(Session::has('status'))
    {{Session::get('status')}}<br />
    @endif
    {{Form::text('username','',array('placeholder'=>'ユーザ名'))}}<br />
    {{Form::password('password',array('placeholder'=>'パスワード'))}}<br />
    @if($errors->has('warning'))
    {{$errors->first('warning')}}<br />
    @endif
    {{Form::checkbox('remember',1,true)}}ログイン状態を保持する<br />
    {{Form::submit('ログイン')}}
    {{Form::close()}}
    <p><a href="/signup">登録はこちら</a></p>
@stop
