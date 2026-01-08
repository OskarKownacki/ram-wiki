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
                <form wire:submit="uploadCsv" class="grid grid-cols-12 gap-4 col-span-12 p-4">
                    <label for="csv_file"
                        class="col-span-2 col-start-1 bg-green-700 hover:bg-green-600 rounded-md p-2 flex items-center justify-between cursor-pointer">
                        CSV Import
                        @svg('heroicon-o-table-cells', ['class' => 'w-6 h-6 text-white'])
                    </label>
                    <input type="file" id="csv_file" name="csv_file" class="hidden" wire:model="csv_file"
                        accept=".csv" />

                    @if ($csv_file)
                        <button type="submit"
                            class="col-span-2 col-start-3 bg-accent hover:bg-secondary rounded-md p-2 flex items-center justify-between">Import
                            @svg('heroicon-o-arrow-up-on-square', ['class' => 'w-6 h-6', 'style' => 'color: #fff'])</button>
                    @endif
                </form>
                <form class="grid grid-cols-12 gap-4 p-4 grid-rows-6" id="ram-form" wire:submit="saveRam"
                    data-tab="1">
                    <div class="col-span-3 row-start-1 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 after:text-red-500 after:content-['*'] mb-1"
                            for="producer">Producer code</label>
                        <input type="text" name="producerCode"
                            class="border-2 rounded-md border-accent focus:ring focus:ring-accent p-2 focus:outline-none bg-primary/50"
                            wire:model="producerCode" />
                    </div>
                    <div class="col-span-3 row-start-1 col-start-4 flex flex-col">
                        <label class="text-white text-sm font-bold after:ml-0.5 mb-1" for="TraitId">Trait name</label>
                        <input type="text" name="TraitId"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none focus:ring focus:ring-accent bg-primary/50"
                            wire:model.live.debounce.150ms='hardwareTraitRam' list="hardwareTraitsAutocomplete" />
                        <datalist id='hardwareTraitsAutocomplete'>
                            @if (isset($autocompleteTraitsRam))
                                @foreach ($autocompleteTraitsRam as $trait)
                                    <option value={{ $trait->name }} class="bg-accent"
                                        wire:key="{{ $trait->id }}" />
                                @endforeach
                            @endif
                        </datalist>
                    </div>
                    <div class="col-span-6 row-start-2 flex flex-col">
                        <label class="text-white text-sm font-bold after:ml-0.5 mb-1"
                            for="Manufacturer">Manufacturer</label>
                        <input type="text" name="Manufacturer"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                            wire:model='manufacturer' />
                    </div>
                    <div class="col-span-6 row-start-3 row-span-3 flex flex-col">
                        <label class="text-white text-sm font-bold after:ml-0.5 mb-1"
                            for="Description">Description</label>
                        <textarea name="Description"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none  bg-primary/50 focus:ring focus:ring-accent"
                            form="ram-form" rows=10 wire:model='description'> </textarea>
                    </div>
                    <div class="col-span-6  row-start-6 flex items-center row-span-1 ">
                        <button class="bg-accent h-12 hover:bg-secondary w-full rounded-md" type="submit">
                            Submit
                        </button>
                    </div>
                </form>
            @elseif($selectedTabId === 2)
                <form wire:submit="uploadCsv" class="grid grid-cols-12 gap-4 col-span-12 p-4">
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
                <form class="grid grid-cols-12 gap-4 p-4 grid-rows-6" id="ram-form" wire:submit="saveServer"
                    data-tab="2">
                    <div class="col-span-6 row-start-1 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 after:text-red-500 after:content-['*'] mb-1"
                            for="producer">Model</label>
                        <input type="text" name="producerCode"
                            class="border-2 rounded-md border-accent focus:ring focus:ring-accent p-2 focus:outline-none bg-primary/50"
                            wire:model="modelServer" />
                    </div>
                    <div class="col-span-6 row-start-2 flex flex-col" x-data="{ open: false }">
                        <label class="text-white text-sm font-bold mb-1" for="TraitId">Trait name</label>

                        <div class="flex flex-wrap gap-2 mb-2">
                            @foreach ($selectedTraits as $index => $traitName)
                                <span class="bg-accent text-white px-2 py-1 rounded-md text-xs flex items-center">
                                    {{ $traitName }}
                                    <button type="button" wire:click="removeTrait({{ $index }})"
                                        class="ml-2 hover:text-red-400">
                                        &times;
                                    </button>
                                </span>
                            @endforeach
                        </div>

                        <input type="text"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none focus:ring focus:ring-accent bg-primary/50 text-white"
                            placeholder="Search and press Enter..."
                            wire:model.live.debounce.150ms="hardwareTraitsServer"
                            wire:keydown.enter.prevent="addTrait($event.target.value)"
                            wire:key="trait-input-{{ count($selectedTraits) }}"
                            list="hardwareTraitsServerAutocomplete" />

                        <datalist id="hardwareTraitsServerAutocomplete">
                            @foreach ($autocompleteTraitsServer as $trait)
                                <option value="{{ $trait->name }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="col-span-6 row-start-3 flex flex-col">
                        <label class="text-white text-sm font-bold after:ml-0.5 mb-1"
                            for="Manufacturer">Manufacturer</label>
                        <input type="text" name="Manufacturer"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                            wire:model='manufacturerServer' />
                    </div>
                    <div class="col-span-6  row-start-4 flex items-center row-span-1 ">
                        <button class="bg-accent h-12 hover:bg-secondary w-full rounded-md" type="submit">
                            Submit
                        </button>
                    </div>
                </form>
            @elseif($selectedTabId === 3)
                <form wire:submit="uploadCsv" class="grid grid-cols-12 gap-4 col-span-12 p-4">
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
                <form wire:submit="saveTrait" class="grid grid-cols-12 gap-4 p-4 grid-rows-6" data-tab="3">
                    <div class="col-span-6 row-start-1 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                            for="traitName">Trait
                            Name</label>
                        <input type="text" name="traitName"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                            wire:model='nameTrait' />
                    </div>
                    <div class="col-span-2 row-start-2 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                            for="traitCapacity">Capacity</label>
                        <input type="text" name="traitCapacity"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                            wire:model='capacityTrait' />
                    </div>
                    <div class="col-span-2 row-start-2 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                            for="traitBundle">Bundle</label>
                        <input type="text" name="traitBundle"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                            wire:model='bundleTrait' />
                    </div>
                    <div class="col-span-2 row-start-2 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                            for="traitType">Type</label>
                        <input type="text" name="traitType"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                            wire:model='typeTrait' />
                    </div>
                    <div class="col-span-2 row-start-3 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                            for="traitRank">Rank</label>
                        <input type="text" name="traitRank"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                            wire:model='rankTrait' />
                    </div>
                    <div class="col-span-2 row-start-3 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                            for="traitSpeed">Speed</label>
                        <input type="text" name="traitSpeed"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                            wire:model='speedTrait' />
                    </div>
                    <div class="col-span-2 row-start-3 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                            for="traitMemoryType">Memory Type</label>
                        <input type="text" name="traitMemoryType"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                            wire:model='memoryTypeTrait' />
                    </div>
                    <div class="col-span-2 row-start-4 flex flex-row items-center justify-start">
                        <input type="checkbox" name="traitEccSupport"
                            class="border-2 size-6 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                            wire:model='eccSupportTrait' />
                        <label
                            class="text-white text-sm font-bold ml-2 align-middle items-center after:text-red-500 after:content-['*']"
                            for="traitEccSupport">ECC Support</label>
                    </div>
                    <div class="col-span-2 row-start-4 flex flex-row items-center justify-start">
                        <input type="checkbox" name="traitEccRegistered"
                            class="border-2 rounded-md border-accent p-2 size-6 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                            wire:model='eccRegisteredTrait' />
                        <label
                            class="text-white text-sm font-bold ml-2 items-center align-middle after:text-red-500 after:content-['*']"
                            for="traitEccRegistered">ECC Registered</label>

                    </div>
                    <div class="col-span-2 row-start-5 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                            for="traitFrequency">Frequency</label>
                        <input type="text" name="traitFrequency"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                            wire:model='frequencyTrait' />
                    </div>
                    <div class="col-span-1 row-start-5 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                            for="traitCycleLatency">Cycle Latency</label>
                        <input type="number" name="traitCycleLatency"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                            wire:model='cycleLatencyTrait' />
                    </div>
                    <div class="col-span-1 row-start-5 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                            for="traitVoltage">Voltage (V)</label>
                        <input type="number" name="traitVoltage"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                            wire:model='voltageTrait' />
                    </div>
                    <div class="col-span-2 row-start-5 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                            for="traitPort">Port</label>
                        <input type="text" name="traitPort"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                            wire:model='portTrait' />
                    </div>
                    <div class="col-span-2 row-start-6 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                            for="traitModuleBuild">Module Build</label>
                        <input type="text" name="traitModuleBuild"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                            wire:model='moduleBuildTrait' />
                    </div>
                    <div class="col-span-2 row-start-6 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                            for="traitModuleAmmount">Module Ammount</label>
                        <input type="text" name="traitModuleAmmount"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                            wire:model='moduleAmmountTrait' />
                    </div>
                    <div class="col-span-2 row-start-6 flex flex-col">
                        <label
                            class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                            for="traitGuarancy">Guarancy</label>
                        <input type="text" name="traitGuarancy"
                            class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                            wire:model='guarancyTrait' />
                    </div>
                    <div class="col-span-6  row-start-7 flex items-center row-span-1 ">
                        <button class="bg-accent h-12 hover:bg-secondary w-full rounded-md" type="submit">
                            Submit
                        </button>
                    </div>
                </form>
            @endif

        </div>
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('scroll-to-tab', ({
                tabId
            }) => {
                setTimeout(() => {
                    const el = document.querySelector(`[data-tab="${tabId}"]`);
                    if (!el) return;

                    const rect = el.getBoundingClientRect();
                    const y = rect.top + window.scrollY;
                    const offset = window.innerHeight / 2 - rect.height / 2;

                    window.scrollTo({
                        top: y - offset,
                        behavior: 'smooth'
                    });
                }, 1);
            });
        });
    </script>

</div>
