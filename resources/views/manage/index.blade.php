@extends('layouts.master')

@section('title')
管理画面 | Owl
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">管理画面</p>
@stop

@section('contents-main')
    <div class="page-header">
        <h5>管理メニュー一覧</h5>
    </div>
    <p><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <a href="/manage/user/index">ユーザー管理</a></p>
    <p><span class="glyphicon glyphicon-tags" aria-hidden="true"></span> <a href="/manage/flow/index">フロータグ管理</a></p>

@stop

@section('contents-sidebar')
@stop
