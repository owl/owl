@section('navbar-menu')
@if(isset($User))
<ul class="nav navbar-nav navbar-right">
    <li><a href="/items/create">投稿する</a></li>
    <li><a href="/stocks">ストック一覧</a></li>

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
@else
<ul class="nav navbar-nav navbar-right">
    <li><a href="/signup">新規登録</a></li>
    <li><a href="/login">ログイン</a></li>
</ul>
@endif
@stop
