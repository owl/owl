@extends('layouts.master')

@section('title')
トピックス一覧 | Owl
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">すべてのトピックス</p>

@stop

@section('contents-main')

    <a href="/topics/create"><button type="button" class="btn btn-success btn-sm">新規作成</button></a><br />

    <br>

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>タイトル</th>
            <th>操作</th>
        </tr>
        @foreach ($topics as $topic)
        <tr>
            <td>{{{ $topic->id }}}</td>
            <td>{{{ $topic->title }}}</td>
            <td>
                {!! Form::open(['route'=>['topics.destroy', $topic->id], 'method'=>'DELETE']) !!}
                <a href="/topics/{{$topic->id}}/edit"><button type="button" class="btn btn-default btn-sm">編集</button></a>
                <button onClick="return confirm('本当に削除しますか？');" type="submit" class="btn btn-danger btn-sm">削除</button>
                {!! Form::close() !!}
            </td>
        </tr>
        @endforeach
    </table>

@stop
