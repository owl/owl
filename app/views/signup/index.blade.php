<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Signup</title>
</head>
<body>
<div class="container">
{{Form::open(array('url'=>'signup/index','class'=>'form-signin'))}}
 <h2>Signup</h2>
{{Form::text('email','',array('class'=>'form-control','placeholder'=>'E-mailアドレス'))}}<br />
{{Form::password('password',array('class'=>'form-control','placeholder'=>'パスワード'))}}<br />
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
