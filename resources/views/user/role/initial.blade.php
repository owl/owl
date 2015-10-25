@extends('layouts.master')

@section('title')
オーナー初期登録 | Owl
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">オーナー初期登録</p>
@stop

@section('contents-main')
<div class="panel panel-default col-sm-offset-3">
    <div class="panel-heading">
        <h3 class="panel-title">ログインユーザーをオーナーとして初期登録します。</h3>
    </div>
    <div class="panel-body">
        {!! Form::open(array('url'=>'user/role/initial', 'class' => 'form-horizontal form-role-initial')) !!}
        @if($errors->has('warning'))
        <div class="alert alert-warning" role="alert">
            {{$errors->first('warning')}}
        </div>
        @endif
        <div class="form-group">
            {!! Form::label('username', 'ユーザー名', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-4">
                <p class="form-control-static">{{ $user->username }}</p>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('email', 'Email', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-4">
                <p class="form-control-static">{{ $user->email }}</p>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                {!! Form::submit('登録', array('class' => 'btn btn-default')) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop

@section('addJs')
<script type="text/javascript" language="JavaScript">
  $(function() {
    $('.form-role-initial').submit(function() {
      $(this).submit(function() {
        alert('処理中です');
        return false;
      });
    });
  });
</script>
@stop
