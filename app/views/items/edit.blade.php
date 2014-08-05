@extends('layouts.master')
@section('addCss')
{{HTML::style('css/style.css')}}
@stop
@section('addJs')
{{HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js')}}
{{HTML::script('js/jquery.upload-1.0.2.min.js')}}
{{HTML::script('js/image.upload.js')}}
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
                <p class="page-title">編集</p>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div id="main" class="col-sm-9">
                    {{Form::open(['route'=>['items.update', $item->open_item_id], 'method'=>'PUT'])}}
                    {{Form::text('title',$item->title,array('class'=>'form-control','placeholder'=>'タイトル'))}}<br />
                    {{Form::textarea('body',$item->body,array('class'=>'form-control','placeholder'=>'本文', 'id' => 'item_text'))}}<br />
                    記事の公開設定：{{Form::select('published', array('0' => '非公開', '1' => '限定公開', '2' => '公開'), $item->published)}}<br /><br />
                    {{Form::submit('投稿',array('class'=>'btn btn-lg btn-primary btn-block'))}}
                    {{Form::close()}}

                    {{Form::open(array('url'=>'image/upload','class'=>'form-items', 'files' => true))}}
                    {{Form::file('image', array('id' => 'file_id')) }}
                    {{Form::close()}}
                </div>

                <div id="sidebar" class="col-sm-3">
                    <ul>
                        <li>{{ HTML::gravator($User->email) }}</li>
                        <li>user_id: {{$User->id}}</li>
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
