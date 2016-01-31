<p>{{ $recipient }}さん</p>

<p>あなたの記事にコメントがつきました</p>

<h4>記事</h4>

<p><a href="{{ route('items.show', ['items' => $itemId]) }}">{{ $itemTitle }}</a></p>

<h4>コメント</h4>

<p>{{ $sender }}さんより</p>

<p>{!! nl2br(e($comment)) !!}</p>
