<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>

    {{-- 🔥 WAJIB: CSS + JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-cover bg-center font-[Inter]"
      style="background-image: url('{{ asset('aset/bgwhite.jpg') }}');">

    {{-- 🔷 HEADER / NAVBAR --}}
<header id="navbar"
    class="fixed top-0 left-0 w-full bg-white/50 backdrop-blur-md shadow z-50 transition-transform duration-300">   
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold tracking-wide text-gray-800">
                MasterIP 
            </h1>

            <nav class="space-x-4">
                <a href="/data" class="text-gray-600 hover:text-blue-500">Data</a>
                <a href="/clip" class="text-gray-600 hover:text-blue-500">CLIPBOARD</a>
                <a href="/logout" class="text-gray-600 hover:text-blue-500">Logout</a>
                <a href="/spekpc" class="text-gray-600 hover:text-blue-500">Spek PC</a>
            </nav>
        </div>
    </header>

    {{-- 🔶 CONTENT --}}
    <main class="max-w-7xl mx-auto p-6 pt-24">
        @yield('content')
    </main>

    {{-- 🔻 FOOTER --}}
    <footer class="bg-white/50 border-t mt-10">
        <div class="max-w-7xl mx-auto px-6 py-4 text-center text-sm text-gray-500">
            © {{ date('Y') }} MasterIP . All rights reserved.
        </div>
        <div class="max-w-7xl mx-auto px-6 py-4 text-center text-sm text-gray-500">
             BY Zmie V1.0 (Beta)
        </div>
    </footer>

</body>
</html>

<script>
let lastScroll = 0;
const navbar = document.getElementById('navbar');

window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;

    if (currentScroll <= 0) {
        navbar.style.transform = 'translateY(0)';
        return;
    }

    if (currentScroll > lastScroll) {
        // scroll ke bawah → hide
        navbar.style.transform = 'translateY(-100%)';
    } else {
        // scroll ke atas → muncul
        navbar.style.transform = 'translateY(0)';
    }

    lastScroll = currentScroll;
});
</script>
<script>
document.addEventListener('mousemove', function(e){
    if (e.clientY < 50) {
        navbar.style.transform = 'translateY(0)';
    }
});
</script>