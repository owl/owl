@extends('layouts.master')
@section('addCss')
{{HTML::style('css/style.css')}}
@stop
@include('layouts.header')
@section('content')
<body>

<h1>Athena</h1>

<h2>menu</h2>
<ul>
    <li><a href="/items/create">投稿する</a></li>
    <li><a href="/logout">ログアウト</a></li>
</ul>

<!-- Contents -->
<div class="container">

  <div class="row">
    <div class="col-sm-8 blog-main">

      <div class="blog-post">

        {{Form::open(array('url'=>'items','class'=>'form-items'))}}
         <h2 class="form-item-heading">新規投稿</h2>
        {{Form::text('title','',array('class'=>'form-control','placeholder'=>'タイトル'))}}
        {{Form::textarea('body','',array('class'=>'form-control','placeholder'=>'本文'))}}
        {{Form::select('published', array('0' => '非公開', '1' => '限定公開', '2' => '公開'), '2')}} 
        {{Form::submit('投稿',array('class'=>'btn btn-lg btn-primary btn-block'))}}
        {{Form::close()}}

    </div><!-- /.blog-main -->

    <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
    </div><!-- /.blog-sidebar -->

  </div><!-- /.row -->

</div><!-- /.container -->
@stop
@section('addJs')
@stop
@include('layouts.footer')
