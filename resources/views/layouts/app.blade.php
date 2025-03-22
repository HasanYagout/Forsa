<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
</head>
<body>
@include('layouts.partials.nav')

<!-- Display Success Message -->
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

<!-- Display Error Message -->
@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif
@yield('content')
@include('layouts.partials.footer')

<script>
    $(document).ready(function () {
        // Toggle mobile menu visibility
        $('#mobile-menu-button').click(function () {
            $('#mobile-menu').toggleClass('hidden');
            $('#menu-closed-icon').toggleClass('hidden');
            $('#menu-open-icon').toggleClass('hidden');
        });

        // Toggle profile dropdown visibility
        $('#user-menu-button').click(function () {
            $('#user-dropdown').toggleClass('hidden');
        });

        // Close the dropdown when clicking outside
        $(document).click(function (event) {
            if (!$(event.target).closest('#user-menu-button, #user-dropdown').length) {
                $('#user-dropdown').addClass('hidden');
            }
        });
    });
</script>

@stack('js')
</body>
</html>
