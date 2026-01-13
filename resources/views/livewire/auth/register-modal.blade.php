<div>
    <button class="bg-accent text-white text-center rounded-md p-2 m-1 w-full"
        wire:click="$set('isOpen', true)">Register</button>


    @if ($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto">
            <div class="fixed inset-0 bg-black opacity-50" wire:click="$set('isOpen', false)"></div>

            <div class="bg-primary rounded-lg shadow-xl p-6 z-10 w-full max-w-md mx-auto">
                <h2 class="text-2xl font-bold mb-4">Rejestracja</h2>

                <form wire:submit.prevent="register">

                    <div class="mb-4">
                        <label class="block text-white">Nazwa użytkownika</label>
                        <input type="text" wire:model="name" class="w-full border rounded p-2">
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-white">Email</label>
                        <input type="email" wire:model="email" class="w-full border rounded p-2">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-white">Hasło</label>
                        <input type="password" wire:model="password" class="w-full border rounded p-2">
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-white">Potwierdź hasło</label>
                        <input type="password" wire:model="password_confirmation" class="w-full border rounded p-2">
                        @error('password_confirmation')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="$set('isOpen', false)"
                            class="px-4 py-2 text-white">Anuluj</button>
                        <button type="submit" class="bg-accent text-white px-4 py-2 rounded">Zarejestruj</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
