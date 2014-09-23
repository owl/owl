@section('contents-sidebar')
<a href="/items/create" class="btn btn-success btn-block">記事を投稿する</a>
<div class="panel panel-default">
    <div class="panel-heading">テンプレートから作成</div>
    <ul class="list-group">
        @foreach ($templates as $template)
        <li class="list-group-item">
            <a href="/items/create?t={{$template->id}}">{{{$template->display_title}}}</a>
        </li>
        @endforeach
    </ul>
</div>
<p><a href="/templates">テンプレート編集</a></p>
<?php if(!empty($rankingStock)) : ?>
投稿ランキング
@for ($i = 0; $i < count($rankingStock); $i++)
<p><a href="{{ action('ItemController@show', $rankingStock[$i]->open_item_id) }}">第{{{ $i + 1 }}}位　{{{ $rankingStock[$i] -> title }}}</a></p>
@endfor
<?php endif; ?>
@stop

