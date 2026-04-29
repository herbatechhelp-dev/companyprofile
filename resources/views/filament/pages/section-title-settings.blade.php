<x-filament-panels::page>

    {{-- Header Info --}}
    <div class="mb-6 p-4 rounded-xl bg-primary-50 border border-primary-200 dark:bg-primary-900/20 dark:border-primary-700 flex items-start gap-3">
        <x-heroicon-o-information-circle class="w-5 h-5 text-primary-600 dark:text-primary-400 flex-shrink-0 mt-0.5" />
        <div class="text-sm text-primary-700 dark:text-primary-300">
            <p class="font-semibold mb-1">Cara Penggunaan</p>
            <p>Ubah judul dan caption di bawah ini, lalu klik <strong>Simpan Perubahan</strong>. Perubahan akan langsung tampil di halaman utama website tanpa perlu refresh cache.</p>
        </div>
    </div>

    {{-- Form --}}
    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getFormActions()"
            :full-width="false"
        />
    </x-filament-panels::form>

</x-filament-panels::page>
