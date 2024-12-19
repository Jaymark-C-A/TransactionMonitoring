
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Transaction Monitoring | Dashboard</title>

<style>
    body {
        font-family: 'Poppins', sans-serif !important;
    }
    h1, h2, h3, p, .btn, span {
        font-family: 'Poppins', sans-serif;
    }
    .smoky-shadow {
        box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px !important;
    }
</style>
<!-- Add this line for the favicon -->
<link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png" sizes="32x32">
<link rel="icon" href="{{ asset('img/logo.png') }}" type="image/svg+xml" sizes="any">
<link rel="shortcut icon" href="{{ asset('img/logo.ico') }}" type="image/x-icon">

<link rel="stylesheet" href="{{ asset('../css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('../css/style.css') }}">
<link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('../css/poppins.css') }}">
<link rel="stylesheet" href="{{ asset('../css/bunny.css') }}">
<link rel="preconnect" href="https://fonts.bunny.net">

<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
<script src="{{ asset('../js/bootstrap.bundle.min.js') }}"></script>
<script src="../js/jquery.min.js"></script>

