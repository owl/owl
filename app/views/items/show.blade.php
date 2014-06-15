@extends('layouts.master')
@section('addCss')
@stop
@include('layouts.header')
@section('content')
<body>

<!-- Fixed navbar -->
<div class="navbar navbar-default" role="navigation">
  <div class="container">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/">Athena</a>
  </div>
  <div class="navbar-collapse collapse navbar-responsive-collapse">
    <form class="navbar-form navbar-left">
      <input type="text" class="form-control col-lg-8" placeholder="Search">
    </form>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="/items/create">投稿する</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{$user->email}} <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="/logout">ログアウト</a></li>
        </ul>
      </li>
    </ul>
  </div>
  </div>
</div>

<!-- Contents -->
<div class="container">

  <div class="row">
    <div class="col-sm-8 blog-main">

      <div class="blog-post">
        <h2 class="blog-post-title">Item詳細</h2>

        <h3>title: {{{ $item->title }}}</h3>
        <p>user_id: {{{ $item->user_id }}}</p>
        <p>body: {{{ $item->body }}}</p>
        <p>published: {{{ $item->published }}}</p>

    </div><!-- /.blog-main -->

    <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
    </div><!-- /.blog-sidebar -->

  </div><!-- /.row -->

</div><!-- /.container -->
@stop
@section('addJs')
@stop
@include('layouts.footer')
