@extends('layouts.master')

@section('title')
新規テンプレート | Owl
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">新規テンプレート作成</p>
@stop

@section('contents-main')
    <br />
    @if($errors->has('display_title'))
    <div class="alert alert-warning" role="alert">
        {{$errors->first('display_title')}}
    </div>
    @endif
    @if($errors->has('title'))
    <div class="alert alert-warning" role="alert">
        {{$errors->first('title')}}
    </div>
    @endif
    @if($errors->has('tags'))
    <div class="alert alert-warning" role="alert">
        {{$errors->first('tags')}}
    </div>
    @endif
    @if($errors->has('body'))
    <div class="alert alert-warning" role="alert">
        {{$errors->first('body')}}
    </div>
    @endif

    {!! Form::open(array('url'=>'templates','class'=>'form-templates')) !!}
    <div class="form-group">
        {!! Form::label('display_title', 'テンプレート名') !!}
        {!! Form::text('display_title','',array('class'=>'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('title', 'タイトル') !!}
        {!! Form::text('title','',array('class'=>'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('tags', 'タグ') !!}
        {!! Form::text('tags','',array('id' => 'tag-input', 'class'=>'form-control', 'placeholder' => '例）日報, php, pjt-timeline')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('body', '本文') !!}
        {!! Form::textarea('body','',array('class'=>'form-control','rows'=>'15', 'id' => 'item_text')) !!}
    </div>

    <div class="form-group">
        <div class="col-sm-8">
        </div>
        <div class="col-sm-4">
            {!! Form::submit('テンプレート作成',array('class'=>'btn btn-success btn-block')) !!}
        </div>
    </div>

    {!! Form::close() !!}
@stop

@section('contents-sidebar')
    @include('layouts.templates-sidebar')
@stop

@section('addJs')
    <script type="text/javascript" language="JavaScript">
        $(function() {
            $('#tag-input').tagit({
                removeConfirmation: true
            });
        });
        $.ajax({
            url: '/tags/suggest',
            dataType: 'json',
            success: function (data) {
                $('#tag-input').tagit({
                    availableTags: data
                })
            }
        });
    </script>
{!! HTML::script('js/jquery.upload-1.0.2.min.js') !!}
{!! HTML::script('js/image.upload.js') !!}
@stop
