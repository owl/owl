@extends('layouts.master')

@section('title')
新規テンプレート | Athena
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">新規テンプレート作成</p>
@stop

@section('contents-main')
    {{Form::open(array('url'=>'templates','class'=>'form-templates'))}}
    {{Form::text('display_title','',array('class'=>'form-control','placeholder'=>'テンプレート名'))}}<br />
    {{Form::text('title','',array('class'=>'form-control','placeholder'=>'タイトル'))}}<br />
    {{Form::textarea('body','',array('class'=>'form-control','placeholder'=>'本文', 'id' => 'item_text'))}}<br /><br />
    {{Form::submit('テンプレート作成',array('class'=>'btn btn-lg btn-success btn-block'))}}
    {{Form::close()}}
@stop

@section('addJs')
{{HTML::script('js/jquery.upload-1.0.2.min.js')}}
{{HTML::script('js/image.upload.js')}}
@stop
