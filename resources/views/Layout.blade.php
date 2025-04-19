<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'D123d')</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="{{ url('CSS/sidebar.css') }}">

</head>

<body>
    <div class="sidebar">
        @include('include.sidebar')
    </div>
    <div class="main-content">
        @yield('content')
    </div>





<!-- =========== Scripts =========  -->
<script src="{{ url('JS/sidebar.js') }}"></script>

<!-- ====== ionicons ======= -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>