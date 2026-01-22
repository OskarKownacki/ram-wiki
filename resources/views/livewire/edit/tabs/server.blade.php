<div>
    <form wire:submit="uploadCsv" class="grid grid-cols-12 gap-4 col-span-12 p-4">
        <label for="csv_file"
            class="col-span-2 col-start-1 bg-green-700 hover:brightness-110 transition rounded-md p-2 flex items-center justify-between cursor-pointer">
            CSV Import
            @svg('heroicon-o-table-cells', ['class' => 'w-6 h-6 text-white'])
        </label>
        <input type="file" id="csv_file" name="csv_file" class="hidden" wire:model="csvFile" accept=".csv" />

        @if ($csvFile && !$importInProgress)
            <button type="submit"
                class="col-span-2 col-start-3 bg-accent rounded-md p-2 flex items-center justify-between cursor-pointer hover:opacity-90 transition-opacity">Import
                @svg('heroicon-o-arrow-up-on-square', ['class' => 'w-6 h-6', 'style' => 'color: #fff'])</button>
        @elseif($importInProgress)
            <div wire:poll.2s="checkProgress"
                class="col-span-2 col-start-3 bg-accent rounded-md p-2 flex items-center justify-between cursor-pointer hover:opacity-90 transition-opacity text-white">
                Import in progress...
                @svg('heroicon-o-arrow-path', ['class' => 'w-6 h-6 animate-spin', 'style' => 'color: #fff'])
            </div>
        @endif
    </form>
    <form class="grid grid-cols-12 gap-4 p-4 items-start" id="ram-form" wire:submit="saveServer" data-tab="2">
        <div class="col-span-6 row-start-1 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 after:text-red-500 after:content-['*'] mb-1"
                for="producer">Model</label>
            <input type="text" name="modelServer"
                class="border-2 rounded-md border-accent focus:ring focus:ring-accent p-2 focus:outline-none bg-primary/50"
                wire:model="modelServer" />
            <div class="h-5">
                @error('modelServer')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-6 row-start-2 flex flex-col">
            <label class="text-white text-sm font-bold mb-1">Trait name</label>

            <div
                class="flex flex-wrap items-center gap-2 border-2 rounded-md border-accent bg-primary/50 p-1.5 focus-within:ring focus-within:ring-accent">

                @foreach ($selectedTraits as $index => $traitName)
                    <span class="bg-accent text-white px-2 py-1 rounded-md text-xs flex items-center whitespace-nowrap">
                        {{ $traitName }}
                        <button type="button" wire:click="removeTrait({{ $index }})"
                            class="ml-2 hover:text-red-400 leading-none text-lg">
                            &times;
                        </button>
                    </span>
                @endforeach

                <input type="text"
                    class="flex-1 min-w-[150px] bg-transparent border-none p-1 text-white focus:ring-0 focus:outline-none placeholder-gray-400"
                    placeholder="{{ count($selectedTraits) ? '' : 'Search and press Enter...' }}"
                    wire:model.live.debounce.150ms="hardwareTraitsServer"
                    wire:keydown.enter.prevent="addTrait($event.target.value)"
                    wire:key="trait-input-{{ count($selectedTraits) }}" list="hardwareTraitsServerAutocomplete">
            </div>

            <datalist id="hardwareTraitsServerAutocomplete">
                @foreach ($autocompleteTraitsServer as $trait)
                    <option value="{{ $trait->name }}">
                @endforeach
            </datalist>
            <div class="h-5">
                @error('hardwareTraitsServer')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-6 row-start-3 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 mb-1" for="Manufacturer">Manufacturer</label>
            <input type="text" name="Manufacturer"
                class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                wire:model='manufacturerServer' />
            <div class="h-5">
                @error('manufacturerServer')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-6  row-start-4 flex items-center row-span-1 ">
            <button class="bg-accent h-12 hover:opacity-90 cursor-pointer transition-opacity w-full rounded-md"
                type="submit">
                Submit
            </button>
        </div>
    </form>
</div>
