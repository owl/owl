<p>{{ $recipient }}さん</p>

<p>あなたの記事が{{ $sender }}さんに編集されました！</p>

<h4>編集された記事</h4>

<p><a href="{{ route('items.show', ['items' => $itemId]) }}">{{ $itemTitle }}</a></p>
