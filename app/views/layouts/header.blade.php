@section('header')
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{{isset($title) ? $title : 'Athena'}}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{HTML::style('tbs/css/bootstrap.min.css')}}
    @yield('addCss')
</head>
@stop
