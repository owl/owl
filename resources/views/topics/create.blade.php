@extends('layouts.master')

@section('title')
新規トピックス作成 | Owl
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">新規トピックス作成</p>
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

    {!! Form::open(array('url'=>'topics','class'=>'form-topics')) !!}
    <div class="form-group">
        {!! Form::label('title', 'タイトル') !!}
        {!! Form::text('title','',array('class'=>'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('body', '本文') !!}
        {!! Form::textarea('body','',array('class'=>'form-control','rows'=>'15', 'id' => 'topic_text')) !!}
    </div>

    <div class="form-group">
        <div class="col-sm-8">
        </div>
        <div class="col-sm-4">
            {!! Form::submit('トピックス作成',array('class'=>'btn btn-success btn-block')) !!}
        </div>
    </div>

    {!! Form::close() !!}
@stop

@section('contents-sidebar')
@stop
