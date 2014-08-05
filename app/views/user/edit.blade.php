@extends('layouts.master')
@section('addCss')
{{HTML::style('css/style.css')}}
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
                <p class="page-title">ユーザー情報編集</p>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div id="main" class="col-sm-9">
                    @if(Session::has('status'))
                    {{Session::get('status')}}<br />
                    @endif
                    {{Form::open(array('url'=>'user/edit', 'method'=>'PUT'))}}
                        {{Form::text('username',$User->username,array('placeholder'=>'ユーザ名'))}}
                        @if($errors->has('username'))
                            {{$errors->first('username')}}
                        @endif
                        <br />
                        {{Form::text('email',$User->email,array('placeholder'=>'Email'))}}
                        @if($errors->has('email'))
                            {{$errors->first('email')}}
                        @endif
                        <br />
                        @if($errors->has('warning'))
                            {{$errors->first('warning')}}<br />
                        @endif
                        {{Form::submit('登録')}}
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
