<div class="sidebar-info">
    <h5>記事リンクMarkdown</h5>
        <input type="text" class="form-control" value="<?php echo "[".$item->title."](".Request::url().")"  ?>">
</div>

<div class="sidebar-user">
    <div class="media">
        <a class="pull-left" href="#">
            {{ HTML::gravator($item->user->email, 30,'mm','g','true',array('class'=>'media-object')) }}
        </a>
        <div class="media-body">
            <h4 class="media-heading"><a href="/{{{$item->user->username}}}" class="username">{{{$item->user->username}}}</a></h4>
        </div>
    </div>
    <h5>最近の投稿</h5>
    <div class="sidebar-user-items">
        <ul>
        @foreach ($user_items as $item)
            <li><a href="{{ action('ItemController@show', $item->open_item_id) }}">{{{ $item->title }}}</a></li>
        @endforeach
        </ul>
    </div>
</div>
