<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Employee System') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Boxicons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    
    <!-- Custom Sidebar CSS -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>

<body id="body-pd">

    <!-- Custom Header & Sidebar Partials -->
    @include('layouts.partials.header')
    @include('layouts.partials.sidebar')

    <!-- Main Page Content -->
    <main class="container-fluid pt-4">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Sidebar JS -->
    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>