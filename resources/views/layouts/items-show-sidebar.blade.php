<div class="sidebar-info">
    <h5>記事リンクMarkdown</h5>
    <div class="sidebar-link-url">
        <input type="text" class="form-control" value="<?php echo "[".$item->title."](".Request::url().")"  ?>">
        <span class="clipboard_area">
            <button class="clipboard_button" data-clipboard-text="copy_text" type="button">
                <span class="clipboard_button_text">copy</span>
            </button>
        </span>
    </div>
</div>

<div class="sidebar-user">
    <hr>
    <div class="media">
        <a class="pull-left" href="#">
            {!! HTML::gravator($item->user->email, 30,'mm','g','true',array('class'=>'media-object')) !!}
        </a>
        <div class="media-body">
            <h4 class="media-heading"><a href="/{{{$item->user->username}}}" class="username">{{{$item->user->username}}}</a></h4>
        </div>
    </div>
    <h6><strong>最近の投稿</strong></h6>
    <div class="sidebar-user-items">
        <ul>
        @foreach ($user_items as $item)
            <li><a href="{{ action('ItemController@show', $item->open_item_id) }}">{{{ $item->title }}}</a></li>
        @endforeach
        </ul>
    </div>
    <hr>
</div>

<div class="sidebar-info">
    @if(!empty($recent_stocks))
        <h6><strong>最新ストック数ランキング</strong></h6>
        <div class="sidebar-info-items">
            <ol>
            @for ($i = 0; $i < count($recent_stocks); $i++)
                <li><a href="{{ action('ItemController@show', $recent_stocks[$i]->open_item_id) }}">{{{ $recent_stocks[$i] -> title }}}</a></li>
            @endfor
            </ol>
        </div>
    @endif
</div>
