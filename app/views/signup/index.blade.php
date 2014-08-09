@extends('layouts.master')

@section('title')
新規ユーザー登録 | Athena
@stop

@section('contents-pagehead')
<p class="page-title">新規ユーザー登録</p>
@stop

@section('contents-main')
    {{Form::open(array('url'=>'signup', 'class' => 'form-horizontal'))}}
    @if($errors->has('warning'))
    <div class="alert alert-warning" role="alert">
        {{$errors->first('warning')}}
    </div>
    @endif
    <div class="form-group">
        {{Form::label('username', 'ユーザ名', array('class' => 'col-sm-2 control-label'))}}
        <div class="col-sm-4">
            {{Form::text('username','',array('class' => 'form-control'))}}
        </div>
    </div>
    @if($errors->has('username'))
    <div class="col-sm-offset-2 col-sm-10">
        <div class="alert alert-warning" role="alert">
            {{$errors->first('username')}}
        </div>
    </div>
    @endif
    <div class="form-group">
        {{Form::label('email', 'Email', array('class' => 'col-sm-2 control-label'))}}
        <div class="col-sm-4">
            {{Form::text('email','',array('class' => 'form-control'))}}
        </div>
    </div>
    @if($errors->has('email'))
    <div class="col-sm-offset-2 col-sm-10">
        <div class="alert alert-warning" role="alert">
            {{$errors->first('email')}}
        </div>
    </div>
    @endif
    <div class="form-group">
        {{Form::label('password', 'パスワード', array('class' => 'col-sm-2 control-label'))}}
        <div class="col-sm-4">
            {{Form::password('password',array('class' => 'form-control'))}}
        </div>
    </div>
    @if($errors->has('password'))
    <div class="col-sm-offset-2 col-sm-10">
        <div class="alert alert-warning" role="alert">
            {{$errors->first('password')}}
        </div>
    </div>
    @endif
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{Form::submit('登録', array('class' => 'btn btn-default'))}}
        </div>
    </div>
    {{Form::close()}}
    <div class="form-group">
        <p><a href="/login">ログインはこちら</a></p>
    </div>





@stop
