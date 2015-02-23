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
    {{HTML::script("/js/stock.change.js")}}
    {{HTML::script("/js/like.change.js")}}
    {{HTML::script("/js/comment.create.js")}}
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
        <h2><a href="/{{{$histories[$i]->user->username}}}">{{ HTML::gravator($histories[$i]->user->email, 30) }} {{ $histories[$i]->user->username }}</a> が {{ date('Y/m/d', strtotime($histories[$i]->updated_at)) }} に作成</h2>
        <h3>本文</h3>
        <div class="content-diff">
            {{ nl2br($histories[$i]->body) }}
        </div>
        <?php continue; ?>
    @endif

<h2><a href="/{{{$histories[$i]->user->username}}}">{{ HTML::gravator($histories[$i]->user->email, 30) }} {{ $histories[$i]->user->username }}</a> が {{ date('Y/m/d', strtotime($histories[$i]->updated_at)) }} に変更</h2>
<h3>本文</h3>
<div class="content-diff">
{{HTML::diff($histories[($i + 1)]->body, $histories[$i]->body)}}
</div>
 <br/>
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
