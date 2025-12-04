<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Ram wiki' }}</title>
    @fluxAppearance
    @vite('resources/css/app.css')
    @livewireStyles
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="bg-primary min-h-screen flex flex-col">
    <header class="mx-[15%]">
        <nav class="grid grid-cols-12 gap-16 p-4">
            <a href="/" class="col-span-3 text-2xl text-center flex items-center">Ram wiki Esus IT</a>
            <a href="edit"
                class="col-span-2 col-start-6 text-center bg-secondary text-white rounded-md p-2 m-1">Edit</a>
            <div class="col-start-10 col-span-3 grid grid-cols-2">
                <a class="bg-secondary text-white text-center rounded-md p-2 m-1" href="/login">Login</a>
                <a class="bg-accent text-white text-center rounded-md p-2 m-1" href="/register">Register</a>
            </div>
        </nav>
    </header>
    <main class="grow">
        {{ $slot }}
    </main>
    @fluxScripts
    <footer class="bg-footer w-full  h-[10vh] flex items-center justify-center text-white">
        &copy; {{ date('Y') }} Ram wiki Esus IT. All rights reserved.
    </footer>
    @livewireScripts
    <x-toaster-hub />
</body>

</html>
