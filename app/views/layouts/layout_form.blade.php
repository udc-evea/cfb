<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>@yield('title', 'UDC-CFB')</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="/favicon.png?v=2">
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}" media="all">
        <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}" media="all">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @yield('main')
                </div>
            </div>
        </div>
    </body>
</html>