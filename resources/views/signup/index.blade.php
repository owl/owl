@extends('layouts.master')

@section('title')
新規ユーザー登録 | Owl
@stop

@section('contents-pagehead')
<p class="page-title">新規ユーザー登録</p>
@stop

@section('contents-main')
<div class="panel panel-default col-sm-offset-3">
    <div class="panel-heading">
        <h3 class="panel-title">新規登録</h3>
    </div>
    <div class="panel-body">
        {!! Form::open(array('url'=>'signup', 'class' => 'form-horizontal')) !!}
        @if($errors->has('warning'))
        <div class="alert alert-warning" role="alert">
            {{$errors->first('warning')}}
        </div>
        @endif
        <div class="form-group">
            {!! Form::label('username', 'ユーザ名', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-4">
                {!! Form::text('username','',array('class' => 'form-control')) !!}
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
            {!! Form::label('email', 'Email', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-4">
                {!! Form::text('email','',array('class' => 'form-control')) !!}
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
            {!! Form::label('password', 'パスワード', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-4">
                {!! Form::password('password',array('class' => 'form-control')) !!}
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
            <div class="col-sm-offset-3 col-sm-9">
                {!! Form::submit('登録', array('class' => 'btn btn-default')) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop

@section('contents-sidebar')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">登録済みの方へ</h3>
    </div>
    <div class="panel-body">
        <a href="/login" type="button" class="btn btn-info btn-block">ログインはこちら</a>
    </div>
</div>
@stop
