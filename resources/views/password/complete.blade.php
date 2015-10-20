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
        <h3 class="panel-title">再設定完了</h3>
    </div>
    <div class="panel-body">
        <p>パスワードの再設定が完了しました。</p>
        <p>新しいパスワードでログインしてください。</p>
        <div class="center-block">
            <div class="col-sm-3">
                <p><a href="/login" type="button" class="btn btn-default btn-block">ログイン</a></p>
            </div>
        </div>
    </div>
</div>
@stop
