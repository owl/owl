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
        <h3 class="panel-title">登録時のメールアドレスを入力してください。</h3>
    </div>
    <div class="panel-body">
        {!! Form::open(array('url'=>'password/reminder', 'class' => 'form-horizontal form-reminder')) !!}
        @if($errors->has('warning'))
        <div class="alert alert-warning" role="alert">
            {{$errors->first('warning')}}
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
            <div class="col-sm-offset-3 col-sm-9">
                {!! Form::submit('再設定メールを送信', array('class' => 'btn btn-default')) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop

@section('addJs')
<script type="text/javascript" language="JavaScript">
  $(function() {
    $('.form-reminder').submit(function() {
      $(this).submit(function() {
        alert('処理中です');
        return false;
      });
    });
  });
</script>
@stop
