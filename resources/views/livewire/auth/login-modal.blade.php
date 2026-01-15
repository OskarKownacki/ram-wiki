<div>
    <button class="bg-secondary text-white text-center rounded-md p-2 m-1 w-full" wire:click="openModal">Login</button>


    @if ($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto">
            <div class="fixed inset-0 bg-black opacity-50" wire:click="$set('isOpen', false)" aria-hidden="true"
                tabindex="-1"></div>

            <div class="bg-primary rounded-lg shadow-xl p-6 z-10 w-full max-w-md mx-auto" role="dialog" aria-modal="true"
                aria-labelledby="login-modal-title" wire:keydown.escape.window="$set('isOpen', false)">
                <h2 class="text-2xl font-bold mb-4">Logowanie</h2>

                <form wire:submit.prevent="login">
                    <div class="mb-4">
                        <label class="block text-white" for="email">Email</label>
                        <input type="email" wire:model="email" class="w-full border rounded p-2" id="email">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-white" for="password">Hasło</label>
                        <input type="password" wire:model="password" class="w-full border rounded p-2" id="password">
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="$set('isOpen', false)"
                            class="px-4 py-2 text-white">Anuluj</button>
                        <button type="submit" class="bg-secondary text-white px-4 py-2 rounded">Zaloguj</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
