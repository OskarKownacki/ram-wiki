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
    <form class="grid grid-cols-12 gap-4 p-4 grid-rows-6" id="ram-form" wire:submit="saveRam" data-tab="1">
        <div class="col-span-3 row-start-1 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 after:text-red-500 after:content-['*'] mb-1"
                for="producer">Producer code</label>
            <input type="text" name="producerCode"
                class="border-2 rounded-md border-accent focus:ring focus:ring-accent p-2 focus:outline-none bg-primary/50"
                wire:model="producerCode" />
            <div class="h-5">
                @error('producerCode')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-3 row-start-1 col-start-4 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 mb-1" for="TraitId">Trait name</label>
            <input type="text" name="TraitId"
                class="border-2 rounded-md border-accent p-2 focus:outline-none focus:ring focus:ring-accent bg-primary/50"
                wire:model.live.debounce.150ms='hardwareTraitRam' list="hardwareTraitsAutocomplete" />
            <div class="h-5">
                @error('hardwareTraitRam')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <datalist id='hardwareTraitsAutocomplete'>
                @if (isset($autocompleteTraitsRam))
                    @foreach ($autocompleteTraitsRam as $trait)
                        <option value={{ $trait->name }} class="bg-accent" wire:key="{{ $trait->id }}" />
                    @endforeach
                @endif
            </datalist>
        </div>
        <div class="col-span-6 row-start-2 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 mb-1" for="Manufacturer">Manufacturer</label>
            <input type="text" name="Manufacturer"
                class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                wire:model='manufacturer' />
            <div class="h-5">
                @error('manufacturer')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-6 row-start-3 row-span-3 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 mb-1" for="Description">Description</label>
            <textarea name="Description"
                class="border-2 rounded-md border-accent p-2 focus:outline-none  bg-primary/50 focus:ring focus:ring-accent"
                form="ram-form" rows=10 wire:model='description'> </textarea>
            <div class="h-5">
                @error('description')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-6  row-start-6 flex items-center row-span-1 ">
            <button class="bg-accent h-12 hover:opacity-90 cursor-pointer transition-opacity w-full rounded-md"
                type="submit">
                Submit
            </button>
        </div>
    </form>
</div>
