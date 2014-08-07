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
@stop

