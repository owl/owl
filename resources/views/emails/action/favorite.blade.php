<p>{{ $recipient }}さん</p>

<p>あなたの記事が{{ $sender }}さんにお気に入りされました！</p>

<h4>お気に入りされた記事</h4>

<p><a href="{{ route('items.show', ['items' => $itemId]) }}">{{ $itemTitle }}</a></p>
