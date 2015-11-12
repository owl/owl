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

    <a href="/topics/create"><button type="button" class="btn btn-success btn-sm">新しくトピックスを作成する</button></a><br />
    <br>

    @if(empty($topics))
        <p>トピックスはまだありません。</p>
    @else

      <?php
      $_topics = array_chunk($topics->toArray()["data"], 4);
      ?>

      @foreach ($_topics as $_k => $_v)
      <div class="row">
          @foreach ($_v as $k => $v)
          <div class="col-xs-4 col-sm-3">

              <div class="panel panel-default">
                  <div class="panel-heading"><a href="/topics/{{$v['id']}}">{{ $v["title"] }}</a></div>
                  <div class="panel-body">
                      最終更新日：<?php echo date('Y/m/d', strtotime($v["updated_at"])); ?>
                  </div>
              </div>

          </div>
          @endforeach
      </div>
      @endforeach
      <?php echo $topics->render(); ?>

    @endif
@stop
