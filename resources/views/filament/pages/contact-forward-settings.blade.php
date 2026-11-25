<x-filament-panels::page>
    @php
        $mailer = config('mail.default');
        $smtpHost = config('mail.mailers.smtp.host');
        $smtpPort = config('mail.mailers.smtp.port');
        $fromAddress = config('mail.from.address');
        $isLocalMailpit = $mailer === 'smtp' && $smtpHost === 'mailpit';
    @endphp

    {{-- Info Konfigurasi Mailer --}}
    <div class="mb-6 p-4 rounded-xl border flex items-start gap-3 {{ $isLocalMailpit ? 'bg-warning-50 border-warning-200 dark:bg-warning-900/20 dark:border-warning-700' : 'bg-primary-50 border-primary-200 dark:bg-primary-900/20 dark:border-primary-700' }}">
        <x-heroicon-o-information-circle class="w-5 h-5 flex-shrink-0 mt-0.5 {{ $isLocalMailpit ? 'text-warning-600 dark:text-warning-400' : 'text-primary-600 dark:text-primary-400' }}" />
        <div class="text-sm {{ $isLocalMailpit ? 'text-warning-800 dark:text-warning-200' : 'text-primary-700 dark:text-primary-300' }}">
            <p class="font-semibold mb-1">Status Pengiriman Email Server</p>
            <p>
                Mailer aktif: <strong>{{ $mailer }}</strong>
                @if($mailer === 'smtp')
                    ({{ $smtpHost }}:{{ $smtpPort }})
                @endif
                &bull; Pengirim: <strong>{{ $fromAddress }}</strong>
            </p>
            @if($isLocalMailpit)
                <p class="mt-1">
                    SMTP saat ini masih mengarah ke <strong>mailpit</strong> (pengujian lokal). Untuk meneruskan ke inbox perusahaan di server live, lengkapi konfigurasi SMTP pada file <code>.env</code>.
                </p>
            @endif
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

