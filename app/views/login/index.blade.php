@extends('layouts.master')

@section('title')
ログイン | Owl
@stop

@section('contents-pagehead')
<p class="page-title">Owlへようこそ！</p>
@stop

@section('contents-main')
<div class="panel panel-default col-sm-offset-3">
    <div class="panel-heading">
        <h3 class="panel-title">ログイン</h3>
    </div>
    <div class="panel-body">
        {{Form::open(array('url'=>'login', 'class' => 'form-horizontal'))}}
        @if(Session::has('status'))
        <div class="alert alert-success" role="alert">
            {{Session::get('status')}}
        </div>
        @endif
        @if($errors->has('warning'))
        <div class="alert alert-warning" role="alert">
            {{$errors->first('warning')}}
        </div>
        @endif
        <div class="form-group">
            {{Form::label('username', 'ユーザ名', array('class' => 'col-sm-3 control-label'))}}
            <div class="col-sm-4">
                {{Form::text('username','',array('class' => 'form-control'))}}
            </div>
        </div>
        <div class="form-group">
            {{Form::label('password', 'パスワード', array('class' => 'col-sm-3 control-label'))}}
            <div class="col-sm-4">
                {{Form::password('password',array('class' => 'form-control'))}}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <div class="checkbox">
                    <label>
                    {{Form::checkbox('remember',1,true)}}ログイン状態を保持する
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                {{Form::submit('ログイン', array('class' => 'btn btn-default'))}}
            </div>
        </div>
        {{Form::close()}}
    </div>
</div>
@stop

@section('contents-sidebar')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">はじめての方へ</h3>
    </div>
    <div class="panel-body">
        <a href="/signup" type="button" class="btn btn-info btn-block">新規登録はこちら</a>
    </div>
</div>
@stop
