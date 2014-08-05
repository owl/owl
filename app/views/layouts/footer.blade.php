@section('footer')
    <div id="footer">
        <div class="container">
            <p>Powered by Athena © 2014</p>
        </div>
    </div>

{{HTML::script("//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js")}}
{{HTML::script("/packages/bootstrap/js/bootstrap.min.js")}}
@yield('addJs')
</body>
</html>
@stop
