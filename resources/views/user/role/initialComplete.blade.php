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
        <h3 class="panel-title">オーナー初期登録完了</h3>
    </div>
    <div class="panel-body">
        <p>オーナーの初期登録が完了しました。</p>
        <div class="center-block">
            <div class="col-sm-3">
                <p><a href="/" type="button" class="btn btn-default btn-block">TOPへ戻る</a></p>
            </div>
        </div>
    </div>
</div>
@stop
