@extends('layouts.app')

@section('content')

<div class="flex items-center justify-center min-h-[70vh]">

    <div class="text-center">

        {{-- TITLE --}}
        <h1 class="text-5xl md:text-6xl font-extrabold text-gray-800 animate-pulse">
            COMING SOON
        </h1>

        {{-- SUBTITLE --}}
        <p class="mt-4 text-gray-500 text-lg">
            Fitur ini sedang dalam pengembangan 🚀
        </p>

        {{-- LOADING DOT ANIMATION --}}
        <div class="flex justify-center mt-6 space-x-2">
            <span class="w-3 h-3 bg-blue-500 rounded-full animate-bounce"></span>
            <span class="w-3 h-3 bg-blue-500 rounded-full animate-bounce [animation-delay:0.2s]"></span>
            <span class="w-3 h-3 bg-blue-500 rounded-full animate-bounce [animation-delay:0.4s]"></span>
        </div>

        {{-- BUTTON BACK --}}
        <div class="mt-8">
            <a href="/data" 
               class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                Kembali
            </a>
        </div>

    </div>

</div>

@endsection