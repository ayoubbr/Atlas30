<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/128/1105/1105470.png" type="image/x-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flash-messages.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
    @yield('css')
</head>

<body>
    <div class="admin-container">
        @include('admin.components.sidebar')
        <div class="flash-messages-container">
            @include('partials.flash-messages')
        </div>
        @yield('content')
    </div>

    @yield('modal')

    <script src="{{ asset('js/flash-messages.js') }}"></script>
    @yield('js')
</body>

</html>
