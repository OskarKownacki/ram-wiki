<div class="mx-[15%] mt-8 grid grid-cols-12 gap-16 gap-y-8 p-4">
    <div class="col-span-12  min-h-[60vh] bg-zinc-600 rounded-xl bg-editor">
        <div class="grid grid-cols-6  mt-2 p-4">
            <button @class([
                'text-3xl',
                'col-span-1',
                'rounded-md',
                'hover:bg-zinc-500' => $selectedTabId !== 1,
                'font-bold border-b-2 border-accent' => $selectedTabId === 1,
            ]) wire:click="setTab(1)">RAM</button>
            <button @class([
                'text-3xl',
                'col-span-1',
                'rounded-md',
                'hover:bg-zinc-500' => $selectedTabId !== 2,
                'font-bold border-b-2 border-accent' => $selectedTabId === 2,
            ]) wire:click="setTab(2)">Server</button>
            <button @class([
                'text-3xl',
                'col-span-1',
                'rounded-md',
                'hover:bg-zinc-500' => $selectedTabId !== 3,
                'font-bold border-b-2 border-accent' => $selectedTabId === 3,
            ]) wire:click="setTab(3)">Trait</button>
        </div>
        <hr class="m-4">
        <div>
            @if ($selectedTabId === 1)
                <form wire:submit="uploadTraitsCsv" class="grid grid-cols-12 gap-4 col-span-12 p-4">
                    <label for="csv_file"
                        class="col-span-2 col-start-1 bg-green-700 rounded-md p-2 flex items-center justify-between cursor-pointer">
                        CSV Import
                        @svg('heroicon-o-table-cells', ['class' => 'w-6 h-6 text-white'])
                    </label>
                    <input type="file" id="csv_file" name="csv_file" class="hidden" wire:model="csv_file"
                        accept=".csv" />

                    @if ($csv_file)
                        <button type="submit"
                            class="col-span-2 col-start-3 bg-accent rounded-md p-2 flex items-center justify-between">Import
                            @svg('heroicon-o-arrow-up-on-square', ['class' => 'w-6 h-6', 'style' => 'color: #fff'])</button>
                    @endif
                </form>
                <form class="grid grid-cols-12 gap-4 p-4 grid-rows-5" id="ram-form">
                    <div class="col-span-3 row-start-1 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 after:text-red-500 after:content-['*'] mb-1"
                            for="ProductCode">Producer code</label>
                        <input type="text" name="ProductCode"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50" />
                    </div>
                    <div class="col-span-3 row-start-1 col-start-4 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 after:text-red-500 after:content-['*'] mb-1"
                            for="TraitId">Trait ID</label>
                        <input type="number" name="TraitId"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50" />
                    </div>
                    <div class="col-span-6 row-start-2 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 after:text-red-500 after:content-['*'] mb-1"
                            for="Manufacturer">Manufacturer</label>
                        <input type="text" name="Manufacturer"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50" />
                    </div>
                    <div class="col-span-6 row-start-3 row-span-3 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 after:text-red-500 after:content-['*'] mb-1"
                            for="Description">Description</label>
                        <textarea name="Description" class="border-2 rounded-md border-accent p-2 focus:outline-none  bg-primary/50"
                            form="ram-form" rows=10> </textarea>
                    </div>
                </form>
            @elseif($selectedTabId === 2)

            @elseif($selectedTabId === 3)
            @endif

        </div>
    </div>

</div>
