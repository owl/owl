<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
</head>
<body>
<div class="container">
{{Form::open(array('url'=>'login/index','class'=>'form-signin'))}}
 <h2>Athena v0.1</h2>
{{Form::text('username','',array('class'=>'form-control','placeholder'=>'ユーザ名'))}}<br />
{{Form::password('password',array('class'=>'form-control','placeholder'=>'パスワード'))}}<br />
@if($errors->has('warning'))
<div class="alert alert-danger">
{{$errors->first('warning')}}
</div>
@endif
{{Form::checkbox('remember',1,true)}}ログイン状態を保持する<br />
{{Form::submit('ログイン',array('class'=>'btn btn-lg btn-primary btn-block'))}}
{{Form::close()}}
<p class="form-nav"><a href="/signup">登録はこちら</a></p>
</div> <!-- /container -->
</body>
</html>
