<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
{{HTML::style('tbs/css/bootstrap.min.css')}}
{{HTML::style('tbs/css/signin.css')}}
</head>
<body>
<div class="container">
{{Form::open(array('url'=>'login/index','class'=>'form-signin'))}}
 <h2 class="form-signin-heading">Athena v0.1</h2>
{{Form::text('email','',array('class'=>'form-control','placeholder'=>'E-mailアドレス'))}}
{{Form::password('password',array('class'=>'form-control','placeholder'=>'パスワード'))}}
@if($errors->has('warning'))
<div class="alert alert-danger">
{{$errors->first('warning')}}
</div>
@endif
{{Form::checkbox('remember',1,true)}}　ログイン状態を保持する
{{Form::submit('ログイン',array('class'=>'btn btn-lg btn-primary btn-block'))}}
{{Form::close()}}
</div> <!-- /container -->
</body>
</html>
