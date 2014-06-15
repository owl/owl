@section('footer')
<div class="blog-footer">
  <p>
    <a href="#">Back to top</a>
  </p>
</div>

{{HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js')}}
{{HTML::script('tbs/js/bootstrap.min.js')}}
@yield('addJs')
</body>
</html>
@stop
