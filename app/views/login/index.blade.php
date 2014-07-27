<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
</head>
<body>
<div>
{{Form::open(array('url'=>'login/index'))}}
 <h2>Athena v0.1</h2>
@if(Session::has('status'))
{{Session::get('status')}}<br />
@endif
{{Form::text('username','',array('placeholder'=>'ユーザ名'))}}<br />
{{Form::password('password',array('placeholder'=>'パスワード'))}}<br />
@if($errors->has('warning'))
{{$errors->first('warning')}}<br />
@endif
{{Form::checkbox('remember',1,true)}}ログイン状態を保持する<br />
{{Form::submit('ログイン')}}
{{Form::close()}}
<p><a href="/signup">登録はこちら</a></p>
</div>
</body>
</html>
