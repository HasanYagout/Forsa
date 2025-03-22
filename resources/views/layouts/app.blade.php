<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.theme.default.min.css')}}">
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/owl.carousel.min.js')}}"></script>
</head>
<body>
@include('layouts.partials.nav')
@yield('content')
@stack('js')
</body>
</html>
