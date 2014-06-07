<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
{{HTML::style('tbs/css/bootstrap.min.css')}}
</head>
<body>
<div class="container">
{{Form::open(array('url'=>'login/index','class'=>'form-signin'))}}
 <h2 class="form-signin-heading">ホーム画面</h2>
<p>ID:{{$user->id}}</p>
<p>email:{{$user->email}}</p>
<br>
<p><a href="/logout">ログアウト</a></p>
</div> <!-- /container -->
</body>
</html>
