@extends('layouts.master')

@section('title')
フロータグ管理 | Owl
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">フロータグ管理</p>
@stop

@section('contents-main')
    @if (Session::has('message'))
        <div class="alert alert-success">{{ Session::get('message') }}</div>
    @endif

    <div class="page-header">
        <h5>フロータグとは</h5>
    </div>
    <p>フロータグとは、トップページのフロー記事の判断に使用されるタグを指します。</p>
    <p>日報や議事録などフロー投稿につけられているタグを、フロータグに設定しましょう。</p>

    {!! Form::open(array('url'=>"manage/flow/store",'class'=>'form-flow-store')) !!}
    <div class="form-inline">
        <div class="form-group">
        {!! Form::select('tag_id', $tags, '', array('class' => 'form-control')) !!}
        </div>
        <div class="form-group">
        {!! Form::submit('フロータグに設定',array('class'=>'btn btn-success btn-sm form-control')) !!}
        </div>
    </div>
    {!! Form::close() !!}

    <br />
    <table class="table table-bordered">
        <tr>
            <th>タグ名</th>
            <th>操作</th>
        </tr>
        @foreach ($flow_tags as $flow_tag)
        <tr>
            <td>{{{ $flow_tag->name }}}</a></td>
            <td>
                {!! Form::open(['route'=>['flow.destroy'], 'method'=>'DELETE']) !!}
                {!! Form::hidden('tag_id', $flow_tag->id) !!}
                <button onClick="return confirm('本当に解除しますか？');" type="submit" class="btn btn-danger btn-sm">解除</button>
                {!! Form::close() !!}
            </td>
        </tr>
        @endforeach
    </table>

@stop

@section('contents-sidebar')
@stop
