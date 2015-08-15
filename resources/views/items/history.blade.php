@extends('layouts.master')

@section ('addJs')
    <script type="text/javascript" language="JavaScript">
    function confirmDelete(t) {
        var answer = confirm("本当に削除しますか？");
        if (answer) {
            t.parentNode.submit()
        }
    }
    </script>
    <script src="{!! \HTML::cached_asset('js/stock.change.js') !!}"></script>
    <script src="{!! \HTML::cached_asset('js/like.change.js') !!}"></script>
    <script src="{!! \HTML::cached_asset('js/comment.create.js') !!}"></script>
    <script src="{!! \HTML::cached_asset('js/item-history.js') !!}"></script>
@stop


@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
@for ($i = 0; $i < count($histories); $i++)
    @if (count($histories) == ($i + 1))
    <p class="page-title">{{ $histories[$i]->title }} の変更履歴</p>
    @endif
@endfor
@stop


@section('contents-main')

<div class="page-body">

@if (count($histories) == '0')
変更履歴はありません
@endif

@for ($i = 0; $i < count($histories); $i++)

  @if (count($histories) == ($i + 1))
    <div class="history-area">
      <h2><a href="/{{{$histories[$i]->user->username}}}">{!! HTML::gravator($histories[$i]->user->email, 30) !!} {{ $histories[$i]->user->username }}</a> が {{ date('Y/m/d', strtotime($histories[$i]->updated_at)) }} に作成<span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></h2>
      <div class="diff-area hidden">
        <h3>本文</h3>
        <div class="content-diff">
          {!! nl2br($histories[$i]->body) !!}
        </div>
      </div>
    </div>
    <?php continue; ?>
  @else
    <div class="history-area">
      <h2><a href="/{{{$histories[$i]->user->username}}}">{!! HTML::gravator($histories[$i]->user->email, 30) !!} {{ $histories[$i]->user->username }}</a> が {{ date('Y/m/d', strtotime($histories[$i]->updated_at)) }} に変更<span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span></h2>
      <div class="diff-area hidden">
        <h3>本文</h3>
        <div class="content-diff">
        {!! HTML::diff($histories[($i + 1)]->body, $histories[$i]->body) !!}
        </div>
        <br/>
      </div>
    </div>
  @endif
@endfor
</div>

@stop

@section('contents-sidebar')
    <h5><strong>変更履歴</strong></h5>
    <ul>
    @for ($i = 0; $i < count($histories); $i++)
        @if (count($histories) == ($i + 1))
        <li>
        <a href="/{{{$histories[$i]->user->username}}}">{{ $histories[$i]->user->username }}</a>が{{ date('Y/m/d', strtotime($histories[$i]->updated_at)) }}に作成<br />
        <?php continue; ?>
        </li>
        @endif
        <li>
        <a href="/{{{$histories[$i]->user->username}}}">{{ $histories[$i]->user->username }}</a>が{{ date('Y/m/d', strtotime($histories[$i]->updated_at)) }}に変更<br />
        </li>
    @endfor
    </ul>
@stop
