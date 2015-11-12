@extends('layouts.master')

@section ('addCss')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
@endsection

@section ('addJs')
    <script type="text/javascript" language="JavaScript">
    function confirmDelete(t) {
        var answer = confirm("本当に削除しますか？");
        if (answer) {
            t.parentNode.submit()
        }
    }
    </script>
    <script src="{!! \HTML::cached_asset('js/contents.js') !!}"></script>
    <script src="{!! \HTML::cached_asset('js/slide.js') !!}"></script>
@stop

@section('title')
    {{{$topic->title}}} | Owl
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<div class="row">
    <div class="col-md-9">
        <h1 class="topic-title">{{{ $topic->title }}}</h1>

        <div class="media">
            <div class="media-body">
                <span class="topic-manage">
                    <p>
                        @if(isset($User))
                            {!! Form::open(['route'=>['topics.destroy', $topic->id], 'method'=>'DELETE']) !!}
                            最終更新日：<?php echo date('Y/m/d', strtotime($topic->updated_at)); ?>　
                            {!! link_to_route('topics.edit','編集',$topic->id) !!}
                            <a onclick="confirmDelete(this);return false;" href="void()">削除</a>
                            <?php // for behat test ?>
                            {!! Form::submit('削除',array('id' => 'topic-delete', 'style'=>'display:none;')) !!}
                            {!! Form::close() !!}
                        @else
                            最終更新日：<?php echo date('Y/m/d', strtotime($topic->updated_at)); ?>　
                        @endif
                    </p>
                </span>

            </div>
        </div>
    </div>
    <div class="col-md-3 vcenter">
        @if(isset($User))
            <div class="media-sidebar">
                <a href="javascript:void(0)" class="btn btn-success btn-block" id="stock_id">この記事をウォッチする</a>
                <input type="hidden" value="{{{ $topic->id }}}" id='topic_id' />
            </div>
        @endif
    </div>
</div>
@stop


@section('contents-main')

<div class="page-body">
{!! HTML::markdown($topic->body) !!}
</div>

@stop

@section('contents-sidebar')
@stop
