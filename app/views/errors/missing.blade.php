@extends('layouts.master')
@section('addCss')
@stop
@include('layouts.header')
@section('content')
<body>

<div id="wrapper">
    <div id="header">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="/" class="navbar-brand">Athena</a>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/items/create">投稿する</a></li>
                        <li><a href="/user/edit">ユーザ情報変更</a></li>
                        <li><a href="/logout">ログアウト</a></li>
                    </ul>
                </div>
            </nav>
    </div>

    <div id="contents">
        <div id="pagehead">
            <div class="container">
                <p class="page-title">404 Not Found</p>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div id="main" class="col-sm-9">
                    <h4>お探しのページは見つかりませんでした</h4>
                </div>

                <div id="sidebar" class="col-sm-3">
                    <ul>
                        <li>{{ HTML::gravator($User->email) }}</li>
                        <li>user_id: {{$User->username}}</li>
                        <li>email: {{$User->email}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

@stop
@section('addJs')
@stop
@include('layouts.footer')
