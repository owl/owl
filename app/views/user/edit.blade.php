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
    <div class="alert alert-success" role="alert">
        {{Session::get('status')}}
    </div>
    @endif
    @if($errors->has('warning'))
    <div class="alert alert-warning" role="alert">
        {{$errors->first('warning')}}
    </div>
    @endif

    {{Form::open(array('url'=>'user/edit', 'class' => 'form-horizontal', 'method'=>'PUT'))}}

    <div class="form-group">
        {{Form::label('username', 'ユーザ名', array('class' => 'col-sm-2 control-label'))}}
        <div class="col-sm-4">
            {{Form::text('username',$User->username,array('class' => 'form-control'))}}
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
            {{Form::text('email',$User->email,array('class' => 'form-control'))}}
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
        <div class="col-sm-offset-2 col-sm-10">
            {{Form::submit('登録', array('class' => 'btn btn-default'))}}
        </div>
    </div>

    {{Form::close()}}
@stop

@section('contents-sidebar')
    @include('layouts.contents-sidebar')
@stop
