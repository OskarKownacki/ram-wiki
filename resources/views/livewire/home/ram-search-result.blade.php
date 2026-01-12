<div
    class="min-h-[10vh] p-2 grid-cols-3 grid border-secondary border-2 bg-sky-800/15 backdrop-blur-xs rounded-md text-white">
    <div class="col-span-2 border-r-2 border-accent">
        <h2 class="text-2xl">{{ $foundRam->product_code }}</h2>
        <p class="text-xl">{{ $foundRam->description }}</p>
        <p>Manufacturer: {{ $foundRam->manufacturer }}</p>
    </div>
    <div class="col-span-1 pl-2">
        <h1 class="text-2xl">Matching servers</h1>
        @foreach ($matchingServers as $server)
            <p>{{ $server->manufacturer }} - {{ $server->model }}</p>
        @endforeach
    </div>
</div>
