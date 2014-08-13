@extends('layouts.master')

@section('title')
編集 | Owl
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">編集</p>
@stop

@section('contents-main')
    <br />
    {{Form::open(['route'=>['items.update', $item->open_item_id], 'method'=>'PUT'], array('class'=>'form-items'))}}

    <div class="form-group">
        {{Form::label('title', 'タイトル')}}
        {{Form::text('title',$item->title,array('class'=>'form-control'))}}
    </div>

    <div class="form-group">
        {{Form::label('body', '本文')}}
        {{Form::textarea('body',$item->body,array('class'=>'form-control', 'rows'=>'15', 'id' => 'item_text'))}}
    </div>

    <div class="form-group">
        <div class="col-sm-8">
        </div>
        <div class="col-sm-4">
            {{Form::label('published', '記事の公開設定：')}}
            {{Form::select('published', array('0' => '非公開', '1' => '限定公開', '2' => '公開'), $item->published)}}
            {{Form::submit('投稿',array('class'=>'btn btn-success btn-block'))}}
        </div>
    </div>

    {{Form::close()}}

    {{Form::open(array('url'=>'image/upload','class'=>'form-items', 'files' => true))}}
    <br />
    <div class="form-group">
        {{Form::label('image', '画像アップロード')}}
        {{Form::file('image', array('id' => 'file_id')) }}
    </div>
    {{Form::close()}}
@stop

@section('contents-sidebar')
    @include('layouts.contents-sidebar')
@stop

@section('addJs')
{{HTML::script('js/jquery.upload-1.0.2.min.js')}}
{{HTML::script('js/image.upload.js')}}
@stop
