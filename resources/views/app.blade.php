<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="csrf-token" value="{{ csrf_token() }}"/>
    <meta name="keywords" content="au theme template">
    <title>{{env('MIX_APP_NAME')}}</title>

    <link href="{{ asset(url('assets/fontawesome-free/css/all.min.css')) }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset(url('assets/vendor/animate.css/animate.min.css')) }}" rel="stylesheet">
    <link href="{{ asset(url('assets/vendor/bootstrap/css/bootstrap.min.css')) }}" rel="stylesheet">
    <link href="{{ asset(url('assets/vendor/bootstrap-icons/bootstrap-icons.css')) }}" rel="stylesheet">
    <link href="{{ asset(url('assets/vendor/swiper/swiper-bundle.min.css')) }}" rel="stylesheet">
    <link href="{{ asset(url('assets/css/style.css')) }}" rel="stylesheet">

    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
</head>

<body class="app">

@if (Auth::check())
    @php
    $user_auth_data = [
        'isLoggedin' => true,
        'user' =>  Auth::user(),
    ];
    @endphp
@else
    @php
    $user_auth_data = [
        'isLoggedin' => false
    ];
    @endphp
@endif

<script>
    window.Laravel = JSON.parse(atob('{{ base64_encode(json_encode($user_auth_data)) }}'));
</script>
<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{ asset(url('assets/jquery/jquery.min.js')) }}"></script>
<script src="{{ asset(url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')) }}"></script>
<script src="{{ asset(url('assets/vendor/swiper/swiper-bundle.min.js')) }}"></script>
<script src="{{ asset(url('assets/vendor/php-email-form/validate.js')) }}"></script>
<script src="{{ asset(url('assets/js/main.js')) }}"></script>

<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>

</body>
</html>