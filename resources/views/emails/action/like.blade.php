<p>{{ $recipient }}さん</p>

<p>あなたの記事に{{ $sender }}さんからいいねがつきました</p>

<h4>記事</h4>

<p><a href="{{ route('items.show', ['items' => $itemId]) }}">{{ $itemTitle }}</a></p>
