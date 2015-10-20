@extends('layouts.master')

@section('title')
パスワード再設定 | Owl
@stop

@section('contents-pagehead')
<p class="page-title">パスワード再設定</p>
@stop

@section('contents-main')
<div class="panel panel-default col-sm-offset-3">
    <div class="panel-heading">
        <h3 class="panel-title">新しいパスワードを設定してください。</h3>
    </div>
    <div class="panel-body">
        {!! Form::open(array('url'=>'password/reset', 'class' => 'form-horizontal')) !!}
        @if($errors->has('warning'))
        <div class="alert alert-warning" role="alert">
            {{$errors->first('warning')}}
        </div>
        @endif
        <div class="form-group">
            {!! Form::label('new_password', '新しいパスワード', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-4">
                {!! Form::password('new_password', array('class' => 'form-control')) !!}
            </div>
        </div>
        @if($errors->has('new_password'))
        <div class="col-sm-offset-3 col-sm-9">
            <div class="alert alert-warning" role="alert">
                {{$errors->first('new_password')}}
            </div>
        </div>
        @endif
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                {!! Form::submit('再設定', array('class' => 'btn btn-default')) !!}
            </div>
        </div>
        {!! Form::hidden('token', $token) !!}
        {!! Form::close() !!}
    </div>
</div>
@stop
