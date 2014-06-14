<!doctype html>
<html>
    <body>
        @section('sidebar')
            ここは親のサイドバー
        @show
 
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
