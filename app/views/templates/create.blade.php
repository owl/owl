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
    <br />
    {{Form::open(array('url'=>'templates','class'=>'form-templates'))}}

    <div class="form-group">
        {{Form::label('display_title', 'テンプレート名')}}
        {{Form::text('display_title','',array('class'=>'form-control'))}}
    </div>

    <div class="form-group">
        {{Form::label('title', 'タイトル')}}
        {{Form::text('title','',array('class'=>'form-control'))}}
    </div>

    <div class="form-group">
        {{Form::label('body', '本文')}}
        {{Form::textarea('body','',array('class'=>'form-control','rows'=>'15', 'id' => 'item_text'))}}
    </div>

    <div class="form-group">
        <div class="col-sm-8">
        </div>
        <div class="col-sm-4">
            {{Form::submit('テンプレート作成',array('class'=>'btn btn-success btn-block'))}}
        </div>
    </div>

    {{Form::close()}}
@stop

@section('addJs')
{{HTML::script('js/jquery.upload-1.0.2.min.js')}}
{{HTML::script('js/image.upload.js')}}
@stop
