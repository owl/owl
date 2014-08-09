@extends('layouts.master')

@section('title')
ログイン | Athena
@stop

@section('contents-pagehead')
<p class="page-title">ログイン</p>
@stop

@section('contents-main')

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
        {{Form::label('username', 'ユーザ名', array('class' => 'col-sm-2 control-label'))}}
        <div class="col-sm-4">
            {{Form::text('username','',array('class' => 'form-control'))}}
        </div>
    </div>
    <div class="form-group">
        {{Form::label('password', 'パスワード', array('class' => 'col-sm-2 control-label'))}}
        <div class="col-sm-4">
            {{Form::password('password',array('class' => 'form-control'))}}
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
                <label>
                {{Form::checkbox('remember',1,true)}}ログイン状態を保持する
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{Form::submit('ログイン', array('class' => 'btn btn-default'))}}
        </div>
    </div>
    {{Form::close()}}
    <div class="form-group">
        <p><a href="/signup">登録はこちら</a></p>
    </div>
@stop
