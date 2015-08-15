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
    @if($errors->has('published'))
    <div class="alert alert-warning" role="alert">
        {{$errors->first('published')}}
    </div>
    @endif
    @if(\Session::has('updated_at'))
    <div class="alert alert-warning" role="alert">
        {{\Session::get('updated_at')}}
    </div>
    @endif

    {!! Form::open(['route'=>['items.update', $item->open_item_id], 'method'=>'PUT'], array('class'=>'form-items')) !!}

    <div class="form-group">
        {!! Form::label('title', 'タイトル') !!}
        {!! Form::text('title',$item->title,array('class'=>'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('tags', 'タグ') !!}
        {!! Form::text('tags',HTML::tags($item->tag->toArray()),array('id' => 'tag-input', 'class'=>'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('body', '本文') !!}
        {!! Form::textarea('body',$item->body,array('class'=>'form-control', 'rows'=>'15', 'id' => 'item_text')) !!}
    </div>

    <div class="form-group">
        <div class="col-sm-8">
        </div>
        <div class="col-sm-4">
            {!! Form::label('published', '記事の公開設定：') !!}
            {!! Form::select('published', array('0' => '非公開', '1' => '限定公開', '2' => '公開'), $item->published) !!}
            {!! Form::hidden('updated_at', $item->updated_at) !!}
            {!! Form::submit('投稿',array('class'=>'btn btn-success btn-block')) !!}
        </div>
    </div>

    {!! Form::close() !!}

    {!! Form::open(array('url'=>'image/upload','class'=>'form-items', 'files' => true)) !!}
    <br />
    <div class="form-group">
        {!! Form::label('image', '画像アップロード') !!}
        {!! Form::file('image', array('id' => 'file_id')) !!}
    </div>
    {!! Form::close() !!}
@stop

@section('contents-sidebar')
<div class="sidebar-user">
    <div class="media">
        <a class="pull-left" href="#">
            {!! HTML::gravator($User->email, 30,'mm','g','true',array('class'=>'media-object')) !!}
        </a>
        <div class="media-body">
            <h4 class="media-heading"><a href="/{{{$User->username}}}" class="username">{{{$User->username}}}</a></h4>
        </div>
    </div>
    <h5>最近の投稿</h5>
    <div class="sidebar-user-items">
        <ul>
        @foreach ($user_items as $item)
            <li><a href="{{ action('ItemController@show', $item->open_item_id) }}">{{{ $item->title }}}</a></li>
        @endforeach
        </ul>
    </div>
</div>
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
<script src="{!! \HTML::cached_asset('js/jquery.upload-1.0.2.min.js') !!}"></script>
<script src="{!! \HTML::cached_asset('js/image.upload.js') !!}"></script>
@stop
