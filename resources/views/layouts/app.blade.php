<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>

    {{-- 🔥 WAJIB: CSS + JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800">

    {{-- 🔷 HEADER / NAVBAR --}}
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">
                MasterIP 
            </h1>

            <nav class="space-x-4">
                <a href="/data" class="text-gray-600 hover:text-blue-500">Data</a>
                <a href="/home" class="text-gray-600 hover:text-blue-500">Home</a>
                <a href="/logout" class="text-gray-600 hover:text-blue-500">Logout</a>
            </nav>
        </div>
    </header>

    {{-- 🔶 CONTENT --}}
    <main class="max-w-7xl mx-auto p-6">
        @yield('content')
    </main>

    {{-- 🔻 FOOTER --}}
    <footer class="bg-white border-t mt-10">
        <div class="max-w-7xl mx-auto px-6 py-4 text-center text-sm text-gray-500">
            © {{ date('Y') }} MasterIP . All rights reserved.
        </div>
        <div class="max-w-7xl mx-auto px-6 py-4 text-center text-sm text-gray-500">
             BY Zmie V1.0 (Beta)
        </div>
    </footer>

</body>
</html>