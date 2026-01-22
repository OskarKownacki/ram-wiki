<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Ram wiki' }}</title>
    @fluxAppearance
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta name="description"
        content="Ram wiki Esus IT - A comprehensive database of RAM modules. Find detailed specifications, compatibility information, and more about various RAM modules.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" media="print" onload="this.media='all'">
</head>

<body class="bg-primary min-h-screen flex flex-col">
    <header class="mx-[15%]">
        <nav class="grid grid-cols-12 gap-2 p-4">
            <a href="/" class="col-span-3 text-2xl text-center flex items-center">Ram wiki Esus IT</a>
            @if (Auth::check() && Auth::user()->is_admin)
                <a href="edit"
                    class="col-span-2 col-start-6 text-center bg-secondary text-white rounded-md p-2 m-1 cursor-pointer hover:opacity-90 transition-opacity">Edit</a>
            @endif
            @guest
                <div class="col-start-10 col-span-3 grid grid-cols-2 gap-2">
                    <livewire:auth.login-modal />
                    <livewire:auth.register-modal />
                </div>
            @endguest
            @auth
                <div class="col-start-10 col-span-3 flex justify-end items-center gap-4">
                    <span class="text-white w-full">Witaj, {{ Auth::user()->name }}</span>
                    <form method="POST" class="w-full" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="bg-secondary w-full text-white rounded-md p-2 m-1 cursor-pointer hover:opacity-90 transition-opacity">Logout</button>
                    </form>
                </div>
            @endauth
        </nav>
    </header>
    <main class="grow">
        {{ $slot }}
    </main>
    <footer class="bg-footer w-full  h-[10vh] flex items-center justify-center text-white">
        &copy; {{ date('Y') }} Ram wiki Esus IT. All rights reserved.
    </footer>

    @vite(['resources/js/app.js'])
    @fluxScripts
    @livewireScripts
    <x-toaster-hub />

</body>

</html>
