<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="/img/favicon.ico">
    {!! HTML::style('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/flick/jquery-ui.css') !!}
    {!! HTML::style('http://fonts.googleapis.com/css?family=Lobster') !!}
    <link rel="stylesheet" type="text/css" href="{!! \HTML::cached_asset('packages/bootstrap/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! \HTML::cached_asset('css/style.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! \HTML::cached_asset('css/jquery.tagit.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! \HTML::cached_asset('css/highight.js-8.1.github.min.css') !!}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('addCss')
</head>
<body>

<!-- wrapper -->
<div id="wrapper">
    <!-- header -->
    <div id="header">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        @yield('title_logo', '<a href="/"><img src="/img/owl_logo_mini.png" class="navbar-brand-image"><span class="navbar-brand">Owl</span></a>')
                    </div>
                    <form class="navbar-form navbar-left" role="search" method="GET" action="/search">
                        <div class="form-group">
                            <input name="q" value="{{isset($q)? $q : ''}}" type="text" class="form-control" placeholder="Search">
                        </div>
                    <button type="submit" class="btn btn-default">検索</button>
                    </form>
                    @yield('navbar-menu')
                </div>
            </nav>
    </div>
    <!-- /header -->

    <!-- contents -->
    <div id="contents">
        <div id="pagehead">
            <div class="container">
                @yield('contents-pagehead', '<p class="page-title">情報を共有しよう。</p>')
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div id="main" class="col-sm-9">
                    @yield('contents-main')
                </div>

                <div id="sidebar" class="col-sm-3">
                    @yield('contents-sidebar')
                </div>
            </div>
        </div>
    </div>
    <!-- /contents -->

    <!-- footer -->
    <div id="footer">
        <div class="container">
            <p>Powered by Owl</p>
        </div>
    </div>
    <!-- /footer -->
</div>
<!-- /wrapper -->

{!! HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js') !!}
{!! HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js') !!}
<script src="{!! \HTML::cached_asset('/packages/bootstrap/js/bootstrap.min.js') !!}"></script>
<script src="{!! \HTML::cached_asset('js/highlight.js-8.1.min.js') !!}"></script>
<script src="{!! \HTML::cached_asset('js/tag-it.js') !!}"></script>
<script>hljs.initHighlightingOnLoad();</script>
@yield('addJs')
</body>
</html>
