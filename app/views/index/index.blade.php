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
                        <li><a href="#">ストック一覧</a></li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ HTML::gravator($User->email, 20) }}<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/{{{$User->username}}}">マイページ</a></li>
                                <li><a href="/user/edit">ユーザ情報変更</a></li>
                                <li class="divider"></li>
                                <li><a href="/logout">ログアウト</a></li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
    </div>

    <div id="contents">
        <div id="pagehead">
            <div class="container">
                <p class="page-title">情報を共有しよう。</p>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div id="main" class="col-sm-9">
                    <div class="items">
                    @foreach ($items as $item)
                        <div class="item">
                            {{ HTML::gravator($item->user->email, 40) }}
                            <p><a href="/{{{$item->user->username}}}" class="username">{{{$item->user->username}}}</a>さんが<?php echo date('Y/m/d', strtotime($item->updated_at)); ?>に投稿しました。</p>
                            <p><a href="{{ action('ItemController@show', $item->open_item_id) }}"><strong>{{{ $item->title }}}</strong></a></p>
                        </div>
                    @endforeach
                    <?php echo $items->links(); ?>
                    </div>
                </div>

                <div id="sidebar" class="col-sm-3">
                    <a href="/items/create" class="btn btn-success btn-block">記事を投稿する</a>
                    <div class="panel panel-default">
                        <div class="panel-heading">テンプレートから作成</div>
                        <ul class="list-group">
                            <li class="list-group-item">日報</li>
                            <li class="list-group-item">障害対応報告</li>
                            <li class="list-group-item">議事録</li>
                            <li class="list-group-item">手順書</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@stop
@section('addJs')
@stop
@include('layouts.footer')
