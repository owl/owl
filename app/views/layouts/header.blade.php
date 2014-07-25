@section('header')
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{{isset($title) ? $title : 'Athena'}}}</title>
    @yield('addCss')
</head>
@stop
