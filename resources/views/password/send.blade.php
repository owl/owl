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
        <h3 class="panel-title">送信完了</h3>
    </div>
    <div class="panel-body">
        <p>{{ $email }} 宛にパスワード再設定のメールをお送りしました。</p>
        <p>メール本文のURLをクリックし、パスワードの再設定をして下さい。</p>
        <p>（登録されている場合のみ、メールが送信されます。）</p>
        <div class="center-block">
            <div class="col-sm-3">
                <p><a href="/login" type="button" class="btn btn-default btn-block">戻る</a></p>
            </div>
        </div>
    </div>
</div>
@stop
