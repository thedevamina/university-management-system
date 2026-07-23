<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'University Management System') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen flex items-center justify-center bg-slate-100 bg-cover bg-center"
      style="background-image: linear-gradient(rgba(15,23,42,.55), rgba(15,23,42,.55)), url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1600');">

    <div class="w-full max-w-sm px-4">

        <div class="text-center mb-6">
            <div class="w-14 h-14 mx-auto rounded-full bg-white flex items-center justify-center text-2xl shadow">
                🎓
            </div>
            <h1 class="text-white font-semibold text-lg mt-3">University Management System</h1>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            {{ $slot }}
        </div>

    </div>

</body>
</html>