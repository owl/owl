@section('navbar-menu')
<ul class="nav navbar-nav navbar-right">
    <li><a href="/items/create">投稿する</a></li>
    <li><a href="#">ストック一覧</a></li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ HTML::gravator($User->email, 20) }}<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="/{{{$User->username}}}">マイページ</a></li>
            <li><a href="/user/edit">ユーザ情報変更</a></li>
            <li class="divider"></li>
            <li><a href="/logout">ログアウト</a></li>
        </ul>
    </li>
</ul>
@stop
