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

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flash-messages.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
    <style>
        :root {
            --primary: #e63946;
            --secondary: #1d3557;
            --accent: #f1c40f;
            --light: #f1faee;
            --dark: #1d3557;
            --success: #2ecc71;
            --info: #3498db;
            --warning: #f39c12;
            --danger: #e74c3c;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f8f9fa;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: var(--dark);
        }

        a {
            text-decoration: none;
            color: var(--primary);
            transition: all 0.3s ease;
        }

        a:hover {
            color: var(--secondary);
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #d32f2f;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: white;
        }

        .btn-secondary {
            background-color: var(--secondary);
        }

        .btn-secondary:hover {
            background-color: #152a45;
        }

        .btn-accent {
            background-color: var(--accent);
            color: var(--dark);
        }

        .btn-accent:hover {
            background-color: #dab10d;
            color: var(--dark);
        }

     
    </style>
    @yield('css')
</head>

<body>
    @include('user.components.header')

    <div class="flash-messages-container">
        @include('partials.flash-messages')
    </div>

    @yield('content')

    @include('user.components.footer')

    <script src="{{ asset('js/flash-messages.js') }}"></script>
    @yield('js')
</body>

</html>
