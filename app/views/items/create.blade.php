<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Item create</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
{{HTML::script('http://code.jquery.com/jquery.js')}}
{{HTML::script('tbs/js/bootstrap.min.js')}}
{{HTML::style('tbs/css/bootstrap.min.css')}}
{{HTML::style('css/style.css')}}
</head>
<body>

<!-- Fixed navbar -->
<div class="navbar navbar-default" role="navigation">
  <div class="container">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/">Athena</a>
  </div>
  <div class="navbar-collapse collapse navbar-responsive-collapse">
    <form class="navbar-form navbar-left">
      <input type="text" class="form-control col-lg-8" placeholder="Search">
    </form>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="/items/create">投稿する</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{$user->email}} <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="/logout">ログアウト</a></li>
        </ul>
      </li>
    </ul>
  </div>
  </div>
</div>

<!-- Contents -->
<div class="container">

  <div class="row">
    <div class="col-sm-8 blog-main">

      <div class="blog-post">

        {{Form::open(array('url'=>'items','class'=>'form-items'))}}
         <h2 class="form-item-heading">新規投稿</h2>
        {{Form::text('title','',array('class'=>'form-control','placeholder'=>'タイトル'))}}
        {{Form::textarea('body','',array('class'=>'form-control','placeholder'=>'本文'))}}
        {{Form::select('published', array('0' => '非公開', '1' => '限定公開', '2' => '公開'), '2')}} 
        {{Form::submit('投稿',array('class'=>'btn btn-lg btn-primary btn-block'))}}
        {{Form::close()}}

    </div><!-- /.blog-main -->

    <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
    </div><!-- /.blog-sidebar -->

  </div><!-- /.row -->

</div><!-- /.container -->

<div class="blog-footer">
  <p>Blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
  <p>
    <a href="#">Back to top</a>
  </p>
</div>

</body>
</html>
