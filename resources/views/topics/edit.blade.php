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
    @if($errors->has('title'))
    <div class="alert alert-warning" role="alert">
        {{$errors->first('title')}}
    </div>
    @endif
    @if($errors->has('body'))
    <div class="alert alert-warning" role="alert">
        {{$errors->first('body')}}
    </div>
    @endif

    {!! Form::open(['route'=>['topics.update', $topic->id], 'method'=>'PUT'], array('class'=>'form-topics')) !!}
    <div class="form-group">
        {!! Form::label('title', 'タイトル') !!}
        {!! Form::text('title',$topic->title,array('class'=>'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('body', '本文') !!}
        {!! Form::textarea('body',$topic->body,array('class'=>'form-control','rows'=>'15', 'id' => 'item_text')) !!}
    </div>

    <div class="form-group">
        <div class="col-sm-8">
        </div>
        <div class="col-sm-4">
            {!! Form::submit('トピックス更新',array('class'=>'btn btn-success btn-block')) !!}
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('contents-sidebar')
@stop
