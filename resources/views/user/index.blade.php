@extends('layouts.master')

@section('title')
ユーザー一覧 | Owl
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">ユーザー一覧</p>
@stop

@section('contents-main')
    @if (Session::has('message'))
        <div class="alert alert-success">{{ Session::get('message') }}</div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>ユーザー名</th>
            <th>Email</th>
            <th>権限</th>
            <th>操作</th>
        </tr>
        @foreach ($users as $user)
        <tr>
            <td>{{{ $user->id }}}</td>
            <td>{{{ $user->username }}}</td>
            <td>{{{ $user->email }}}</td>
            <td>{{{ $user->userRole->name }}}</td>
            <td>
                {!! Form::open(array('url'=>"user/{$user->id}/roleUpdate",'class'=>'form-role-update')) !!}
                <div class="form-inline">
                    <div class="form-group">
                    {!! Form::select('role_id', $roles, $user->role , array('class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                    {!! Form::submit('変更',array('class'=>'btn btn-default btn-sm form-control')) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        @endforeach
    </table>
@stop
