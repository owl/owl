<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Signup</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
{{HTML::style('tbs/css/bootstrap.min.css')}}
{{HTML::style('tbs/css/signin.css')}}
</head>
<body>
<div class="container">
{{Form::open(array('url'=>'signup/index','class'=>'form-signin'))}}
 <h2 class="form-signin-heading">Signup</h2>
{{Form::text('email','',array('class'=>'form-control','placeholder'=>'E-mailアドレス'))}}
{{Form::password('password',array('class'=>'form-control','placeholder'=>'パスワード'))}}
@if($errors->has('warning'))
<div class="alert alert-danger">
{{$errors->first('warning')}}
</div>
@endif
{{Form::submit('登録',array('class'=>'btn btn-lg btn-primary btn-block'))}}
{{Form::close()}}
<p class="form-nav"><a href="/login">ログインはこちら</a></p>
</div> <!-- /container -->
</body>
</html>
