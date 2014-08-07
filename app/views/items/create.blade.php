@extends('layouts.master')

@section('title')
新規投稿 | Athena
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">新規投稿</p>
@stop

@section('contents-main')
    {{Form::open(array('url'=>'items','class'=>'form-items'))}}
    {{Form::text('title', isset($template->title) ? $template->title : '' ,array('class'=>'form-control','placeholder'=>'タイトル'))}}<br />
    {{Form::textarea('body', isset($template->body) ? $template->body : '' ,array('class'=>'form-control','placeholder'=>'本文', 'id' => 'item_text'))}}
    記事の公開設定：{{Form::select('published', array('0' => '非公開', '1' => '限定公開', '2' => '公開'), '2')}}<br /><br />
    {{Form::submit('投稿',array('class'=>'btn btn-lg btn-success btn-block'))}}
    {{Form::close()}}

    {{Form::open(array('url'=>'image/upload','class'=>'form-items', 'files' => true))}}
    {{Form::file('image', array('id' => 'file_id')) }}
    {{Form::close()}}
@stop

@section('addJs')
{{HTML::script('js/jquery.upload-1.0.2.min.js')}}
{{HTML::script('js/image.upload.js')}}
@stop
