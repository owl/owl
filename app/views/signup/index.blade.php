<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Signup</title>
    {{HTML::style('packages/bootstrap/css/bootstrap.min.css', array('media'=>'screen'))}}
    {{HTML::style('css/style.css')}}
    {{HTML::style('http://fonts.googleapis.com/css?family=Allerta')}}
</head>
<body>

<div id="wrapper">
    <div id="header">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="/" class="navbar-brand">Athena</a>
                    </div>
                </div>
            </nav>
    </div>

    <div id="contents">
        <div id="pagehead">
            <div class="container">
                <p class="page-title">新規会員登録</p>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div id="main" class="col-sm-9">
                    {{Form::open(array('url'=>'signup'))}}
                        {{Form::text('username','',array('placeholder'=>'ユーザ名'))}}
                        @if($errors->has('username'))
                            {{$errors->first('username')}}
                        @endif
                        <br />
                        {{Form::text('email','',array('placeholder'=>'Email'))}}
                        @if($errors->has('email'))
                            {{$errors->first('email')}}
                        @endif
                        <br />
                        {{Form::password('password',array('placeholder'=>'パスワード'))}}
                        @if($errors->has('password'))
                            {{$errors->first('password')}}
                        @endif
                        <br />
                        @if($errors->has('warning'))
                            {{$errors->first('warning')}}<br />
                        @endif
                        {{Form::submit('登録')}}
                    {{Form::close()}}
                    <p><a href="/login">ログインはこちら</a></p>
                </div>

                <div id="sidebar" class="col-sm-3">
                    <ul>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>
