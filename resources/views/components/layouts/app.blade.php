<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Ram wiki' }}</title>
    @fluxAppearance
    @vite('resources/css/app.css')
</head>

<body class="bg-zinc-800 min-h-screen flex flex-col">
    <header class="mx-[15%]">
        <nav class="grid grid-cols-12 gap-16 p-4">
            <a href="/" class="col-span-3 text-2xl text-center flex items-center">Ram wiki Esus IT</a>
            <a href="/" class="col-start-5 col-span-2 text-center text-xl flex items-center">Edit RAMs</a>
            <a href="/" class="col-start-7 col-span-2 text-center text-xl flex items-center">Edit server racks</a>
            <div class="col-start-10 col-span-3 grid grid-cols-2">
                <a class="bg-blue-700 text-white text-center rounded-md p-2 m-1" href="/login">Login</a>
                <a class="bg-gray-500 text-white text-center rounded-md p-2 m-1" href="/register">Register</a>
            </div>
        </nav>
    </header>
    <main class="flex-grow">
        {{ $slot }}
    </main>
    @fluxScripts
    <footer class="bg-zinc-700 w-full  h-[10vh] flex items-center justify-center text-white">
        &copy; {{ date('Y') }} Ram wiki Esus IT. All rights reserved.
    </footer>

</body>

</html>
