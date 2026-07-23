<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'University Management System') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen flex items-center justify-center bg-cover bg-center"
      style="background-image: linear-gradient(rgba(15,23,42,.55), rgba(15,23,42,.55)), url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1600');">

    <div class="text-center px-4">
        <div class="w-16 h-16 mx-auto rounded-full bg-white flex items-center justify-center text-3xl shadow mb-4">
            🎓
        </div>
        <h1 class="text-white text-2xl font-semibold mb-1">University Management System</h1>
        <p class="text-slate-200 text-sm mb-6">Please log in to continue</p>

        <a href="{{ route('login') }}" class="inline-block px-6 py-2.5 rounded-md bg-white text-slate-800 font-medium text-sm shadow hover:bg-slate-100">
            Log in
        </a>
    </div>

</body>
</html>