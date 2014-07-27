<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Signup</title>
</head>
<body>
<div>
<h2>Signup</h2>
{{Form::open(array('url'=>'signup/index'))}}
    {{Form::text('username','',array('placeholder'=>'ユーザ名'))}}
    @if($errors->has('username'))
        {{$errors->first('username')}}
    @endif
    <br />
    {{Form::text('email','',array('placeholder'=>'Email'))}}<br />
    {{Form::password('password',array('placeholder'=>'パスワード'))}}<br />
    @if($errors->has('warning'))
        {{$errors->first('warning')}}<br />
    @endif
    {{Form::submit('登録')}}
{{Form::close()}}
<p><a href="/login">ログインはこちら</a></p>
</div>
</body>
</html>
