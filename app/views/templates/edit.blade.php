@extends('layouts.master')

@section('title')
編集 | Athena
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">編集</p>
@stop

@section('contents-main')
    {{Form::open(['route'=>['templates.update', $template->id], 'method'=>'PUT'])}}
    {{Form::text('display_title',$template->display_title,array('class'=>'form-control','placeholder'=>'テンプレート名'))}}<br />
    {{Form::text('title',$template->title,array('class'=>'form-control','placeholder'=>'タイトル'))}}<br />
    {{Form::textarea('body',$template->body,array('class'=>'form-control','placeholder'=>'本文', 'id' => 'item_text'))}}<br /><br />
    {{Form::submit('テンプレート更新',array('class'=>'btn btn-lg btn-success btn-block'))}}
    {{Form::close()}}
@stop

@section('addJs')
{{HTML::script('js/jquery.upload-1.0.2.min.js')}}
{{HTML::script('js/image.upload.js')}}
@stop
