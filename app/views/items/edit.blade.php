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
    {{Form::open(['route'=>['items.update', $item->open_item_id], 'method'=>'PUT'])}}
    {{Form::text('title',$item->title,array('class'=>'form-control','placeholder'=>'タイトル'))}}<br />
    {{Form::textarea('body',$item->body,array('class'=>'form-control','placeholder'=>'本文', 'id' => 'item_text'))}}<br />
    記事の公開設定：{{Form::select('published', array('0' => '非公開', '1' => '限定公開', '2' => '公開'), $item->published)}}<br /><br />
    {{Form::submit('投稿',array('class'=>'btn btn-lg btn-primary btn-block'))}}
    {{Form::close()}}

    {{Form::open(array('url'=>'image/upload','class'=>'form-items', 'files' => true))}}
    {{Form::file('image', array('id' => 'file_id')) }}
    {{Form::close()}}
@stop

@section('contents-sidebar')
    @include('layouts.contents-sidebar')
@stop

@section('addJs')
{{HTML::script('js/jquery.upload-1.0.2.min.js')}}
{{HTML::script('js/image.upload.js')}}
@stop
