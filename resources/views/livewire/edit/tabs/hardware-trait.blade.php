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
    <form wire:submit="saveTrait" class="grid grid-cols-12 gap-4 p-4 grid-rows-6" data-tab="3">
        <div class="col-span-6 row-start-1 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                for="traitName">Trait
                Name</label>
            <input type="text" name="traitName"
                class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                wire:model='nameTrait' />
            <div class="h-5">
                @error('nameTrait')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-2 row-start-2 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                for="traitCapacity">Capacity</label>
            <input type="text" name="traitCapacity"
                class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                wire:model='capacityTrait' />
            <div class="h-5">
                @error('capacityTrait')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-2 row-start-2 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                for="traitBundle">Bundle</label>
            <input type="text" name="traitBundle"
                class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                wire:model='bundleTrait' />
            <div class="h-5">
                @error('bundleTrait')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-2 row-start-2 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                for="traitType">Type</label>
            <input type="text" name="traitType"
                class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                wire:model='typeTrait' />
            <div class="h-5">
                @error('typeTrait')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-2 row-start-3 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                for="traitRank">Rank</label>
            <input type="text" name="traitRank"
                class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                wire:model='rankTrait' />
            <div class="h-5">
                @error('rankTrait')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-2 row-start-3 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                for="traitSpeed">Speed</label>
            <input type="text" name="traitSpeed"
                class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                wire:model='speedTrait' />
            <div class="h-5">
                @error('speedTrait')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-2 row-start-3 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                for="traitMemoryType">Memory Type</label>
            <input type="text" name="traitMemoryType"
                class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                wire:model='memoryTypeTrait' />
            <div class="h-5">
                @error('memoryTypeTrait')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-2 row-start-4 flex flex-row items-center justify-start">
            <input type="checkbox" name="traitEccSupport"
                class="border-2 size-6 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                wire:model='eccSupportTrait' />
            <label
                class="text-white text-sm font-bold ml-2 align-middle items-center after:text-red-500 after:content-['*']"
                for="traitEccSupport">ECC Support</label>
            <div class="h-5">
                @error('eccSupportTrait')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-2 row-start-4 flex flex-row items-center justify-start">
            <input type="checkbox" name="traitEccRegistered"
                class="border-2 rounded-md border-accent p-2 size-6 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                wire:model='eccRegisteredTrait' />
            <label
                class="text-white text-sm font-bold ml-2 items-center align-middle after:text-red-500 after:content-['*']"
                for="traitEccRegistered">ECC Registered</label>
            <div class="h-5">
                @error('eccRegisteredTrait')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

        </div>
        <div class="col-span-2 row-start-5 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                for="traitFrequency">Frequency</label>
            <input type="text" name="traitFrequency"
                class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                wire:model='frequencyTrait' />
            <div class="h-5">
                @error('frequencyTrait')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-1 row-start-5 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                for="traitCycleLatency">Cycle Latency</label>
            <input type="number" name="traitCycleLatency"
                class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                wire:model='cycleLatencyTrait' />
            <div class="h-5">
                @error('cycleLatencyTrait')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-1 row-start-5 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                for="traitVoltage">Voltage (V)</label>
            <input type="number" name="traitVoltage"
                class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                wire:model='voltageTrait' />
            <div class="h-5">
                @error('voltageTrait')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-2 row-start-5 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                for="traitPort">Port</label>
            <input type="text" name="traitPort"
                class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                wire:model='portTrait' />
            <div class="h-5">
                @error('portTrait')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-2 row-start-6 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                for="traitModuleBuild">Module Build</label>
            <input type="text" name="traitModuleBuild"
                class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                wire:model='moduleBuildTrait' />
            <div class="h-5">
                @error('moduleBuildTrait')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-2 row-start-6 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                for="traitModuleAmmount">Module Ammount</label>
            <input type="text" name="traitModuleAmmount"
                class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                wire:model='moduleAmmountTrait' />
            <div class="h-5">
                @error('moduleAmmountTrait')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-2 row-start-6 flex flex-col">
            <label class="text-white text-sm font-bold after:ml-0.5 mb-1 after:text-red-500 after:content-['*']"
                for="traitGuarancy">Guarancy</label>
            <input type="text" name="traitGuarancy"
                class="border-2 rounded-md border-accent p-2 focus:outline-none bg-primary/50 focus:ring focus:ring-accent"
                wire:model='guarancyTrait' />
            <div class="h-5">
                @error('guarancyTrait')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-span-6  row-start-7 flex items-center row-span-1 ">
            <button class="bg-accent h-12 hover:opacity-90 cursor-pointer transition-opacity w-full rounded-md"
                type="submit">
                Submit
            </button>
        </div>
    </form>
</div>
