<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Ram wiki' }}</title>
        @fluxAppearance
    </head>
    <body>
       <header>
        <nav class="grid grid-cols-4 gap-4">
            <a href="{{ route('home') }}" class="w-24 bg-white">Home</a>

        </nav>
       </header> 

        @fluxScripts
    </body>
</html>