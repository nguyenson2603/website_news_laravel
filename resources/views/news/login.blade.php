<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <title>My Login Page &mdash; Bootstrap 4 Login Page Snippet</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/my-login.css') }}">
</head>

<body class="my-login-page">
    @yield('content')
    <script src="{{ asset('auth/js/jquery.min.js') }}"></script>
    <script src="{{ asset('auth/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('auth/js/my-login.js') }}"></script>
</body>

</html>
