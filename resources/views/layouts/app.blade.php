<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @yield('title') </title>

    <link rel="stylesheet" href="{{ asset('/app/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/app/css/font-awesome.min.css') }}">
    @stack('style')
</head>
<body>

    @yield('content')

    <script src="{{ asset('/app/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/app/js/popper.min.js') }}"></script>
    <script src="{{ asset('/app/js/bootstrap.bundle.min.js') }}"></script>
    @stack('script')
</body>
</html>
