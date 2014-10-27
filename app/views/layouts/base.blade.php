<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>@yield('title', 'UDC-CFB')</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        @include('layouts.assets')
    </head>
    <body>
        <div id="container" class="container">
            <div class="row">
                <div class="col-md-12">
                    @yield('main')
                </div>
            </div>
        </div>
    </body>
</html>