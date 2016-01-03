@extends('layouts.master')

@section('title')
ユーザー情報変更 | Owl
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

    <div class="page-header">
        <h5>アカウント設定</h5>
    </div>
    {!! Form::open(array('url'=>'user/edit', 'class' => 'form-horizontal', 'method'=>'PUT')) !!}

    <div class="form-group">
        {!! Form::label('username', 'ユーザ名', array('class' => 'col-sm-3 control-label')) !!}
        <div class="col-sm-4">
            {!! Form::text('username',$User->username,array('class' => 'form-control')) !!}
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
            {!! Form::text('email',$User->email,array('class' => 'form-control')) !!}
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
            {!! Form::submit('登録', array('class' => 'btn btn-default')) !!}
        </div>
    </div>

    {!! Form::close() !!}

    <div class="page-header">
        <h5>パスワード設定</h5>
    </div>

    {!! Form::open(array('url'=>'user/password', 'class' => 'form-horizontal', 'method'=>'POST')) !!}

    <div class="form-group">
        {!! Form::label('password', '現在のパスワード', array('class' => 'col-sm-3 control-label')) !!}
        <div class="col-sm-4">
            {!! Form::password('password',array('class' => 'form-control')) !!}
        </div>
    </div>
    @if($errors->has('password'))
    <div class="col-sm-offset-3 col-sm-9">
        <div class="alert alert-warning" role="alert">
            {{$errors->first('password')}}
        </div>
    </div>
    @endif

    <div class="form-group">
        {!! Form::label('new_password', '新しいパスワード', array('class' => 'col-sm-3 control-label')) !!}
        <div class="col-sm-4">
            {!! Form::password('new_password',array('class' => 'form-control')) !!}
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
        <div class="col-sm-offset-3 col-sm-9">
            {!! Form::submit('変更', array('class' => 'btn btn-default')) !!}
        </div>
    </div>

    {!! Form::close() !!}

    <div class="page-header">
        <h5>プロフィール画像設定</h5>
    </div>
    <p>
        Gravatarという外部サービスを利用してEmailに紐付けられた画像を表示しています。<br/>
        プロフィール画像を設定したい場合は、<a href="http://ja.gravatar.com/" target="_blank">こちら</a>から登録しEmailと画像を紐付けください。
    </p>

    <div class="page-header">
        <h5>通知メール送信設定</h5>
    </div>

    <p>
        それぞれの項目に対してメールで通知するかどうか設定できます。
    </p>

    <br />

    <div class="form-group mail-checkbox-form">
        {!! Form::label('comment-mail-checkbox', 'コメントがついた時', array('class' => 'col-sm-4 control-label mail-checkbox')) !!}
        <div class="col-sm-4 mail-checkbox">
            {!! Form::checkbox('comment-mail-checkbox', 'comment', !!$notifyFlags->comment_notification_flag) !!}
        </div>
    </div>
    <br />
    <div class="form-group mail-checkbox-form">
        {!! Form::label('favorite-mail-checkbox', '記事がお気に入りされた時', array('class' => 'col-sm-4 control-label mail-checkbox')) !!}
        <div class="col-sm-4 mail-checkbox">
            {!! Form::checkbox('favorite-mail-checkbox', 'favorite', !!$notifyFlags->favorite_notification_flag) !!}
        </div>
    </div>
    <br />
    <div class="form-group mail-checkbox-form">
        {!! Form::label('like-mail-checkbox', 'いいねがついた時', array('class' => 'col-sm-4 control-label mail-checkbox')) !!}
        <div class="col-sm-4 mail-checkbox">
            {!! Form::checkbox('like-mail-checkbox', 'like', !!$notifyFlags->like_notification_flag) !!}
        </div>
    </div>
    <br />
    <div class="form-group mail-checkbox-form">
        {!! Form::label('edit-mail-checkbox', '自分の記事が編集された時', array('class' => 'col-sm-4 control-label mail-checkbox')) !!}
        <div class="col-sm-4 mail-checkbox">
            {!! Form::checkbox('edit-mail-checkbox', 'edit', !!$notifyFlags->edit_notification_flag) !!}
        </div>
    </div>
@stop

@section('contents-sidebar')
    @include('layouts.contents-sidebar')
@stop

@section('addCss')
    <link rel="stylesheet" type="text/css" href="{!! \HTML::cached_asset('/packages/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') !!}"/>
@stop

@section('addJs')
    <script src="{!! \HTML::cached_asset('/packages/bootstrap-switch/dist/js/bootstrap-switch.min.js') !!}"></script>
    <script src="{!! \HTML::cached_asset('/js/edit/switch.js') !!}"></script>
    <script src="{!! \HTML::cached_asset('/js/edit/set-notification.js') !!}"></script>
@stop
