<div class="mx-[15%] mt-8 grid grid-cols-12 gap-16 gap-y-8 p-4">
    <div class="col-span-12  min-h-[60vh] bg-zinc-600 rounded-xl bg-editor">
        <div class="grid grid-cols-6  mt-2 p-4">
            <button @class([
                'text-3xl',
                'col-span-1',
                'rounded-md',
                'cursor-pointer',
                'hover:bg-zinc-500' => $selectedTabId !== 1,
                'font-bold border-b-2 border-accent' => $selectedTabId === 1,
            ]) wire:click="setTab(1)">RAM</button>
            <button @class([
                'text-3xl',
                'col-span-1',
                'rounded-md',
                'cursor-pointer',
                'hover:bg-zinc-500' => $selectedTabId !== 2,
                'font-bold border-b-2 border-accent' => $selectedTabId === 2,
            ]) wire:click="setTab(2)">Server</button>
            <button @class([
                'text-3xl',
                'col-span-1',
                'rounded-md',
                'cursor-pointer',
                'hover:bg-zinc-500' => $selectedTabId !== 3,
                'font-bold border-b-2 border-accent' => $selectedTabId === 3,
            ]) wire:click="setTab(3)">Trait</button>
        </div>
        <hr class="m-4">
        <div>
            @if ($selectedTabId === 1)
                <livewire:edit.tabs.ram />
            @elseif($selectedTabId === 2)
                <livewire:edit.tabs.server />
            @elseif($selectedTabId === 3)
                <livewire:edit.tabs.hardware-trait />
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
