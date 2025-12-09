<div>
    <div class="mx-[15%] mt-8 grid grid-cols-12 gap-16 p-4">
        <form class="col-span-10 col-start-2 flex flex-row" wire:submit="onSearchSubmit">
            <input type="text" placeholder="Search RAMs..." list="autocompleteList"
                wire:model.live.debounce.250ms="searchValue"
                class="w-full p-3 h-full rounded-full focus:outline-none rounded-r-none text-white bg-secondary placeholder:text-white" />
            <datalist id="autocompleteList">
                @if (isset($autocompleteValues))
                    @foreach ($autocompleteValues as $autocompleteValue)
                        <option value={{ $autocompleteValue->product_code }}> </option>
                    @endforeach
                @endif
            </datalist>
            <button type="submit" class="bg-secondary text-white rounded-full p-3 h-full rounded-l-none">
                @svg('heroicon-o-ellipsis-vertical', ['class' => 'w-6 h-6', 'style' => 'color: #ffffff'])
            </button>
        </form>
        <div class="col-span-10 col-start-2">
            @if (isset($foundRams))
                @foreach ($foundRams as $foundRam)
                    <livewire:home.ram-search-result :foundRam="$foundRam" />
                @endforeach
            @endif
        </div>
    </div>

</div>
