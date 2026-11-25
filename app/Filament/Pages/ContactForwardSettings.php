<?php

namespace App\Filament\Pages;

use App\Mail\ContactMessageForwarded;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactForwardSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    protected static ?string $navigationGroup = 'Manajemen Situs';

    protected static ?string $navigationLabel = 'Forward Email Pesan';

    protected static ?string $title = 'Pengaturan Forward Email Pesan';

    protected static ?int $navigationSort = 6;

    protected static string $view = 'filament.pages.contact-forward-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            SiteSetting::CONTACT_FORWARD_ENABLED_KEY => SiteSetting::isContactForwardEnabled(),
            SiteSetting::CONTACT_FORWARD_EMAIL_KEY => SiteSetting::getContactForwardEmails(),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Penerusan Pesan Kontak ke Email Perusahaan')
                    ->description('Setiap pesan yang dikirim melalui halaman Contact tetap tersimpan di menu Pesan, dan akan diteruskan otomatis ke alamat email di bawah jika fitur ini aktif.')
                    ->schema([
                        Toggle::make(SiteSetting::CONTACT_FORWARD_ENABLED_KEY)
                            ->label('Aktifkan Forward Email Pesan')
                            ->helperText('Jika aktif, setiap pesan masuk dari form Contact akan otomatis dikirim ke daftar email penerima.')
                            ->live(),

                        TagsInput::make(SiteSetting::CONTACT_FORWARD_EMAIL_KEY)
                            ->label('Email Perusahaan Penerima Forward')
                            ->placeholder('Ketik alamat email lalu tekan Enter...')
                            ->separator(',')
                            ->splitKeys(['Tab', ',', ' '])
                            ->nestedRecursiveRules(['email'])
                            ->suggestions(fn (): array => array_values(array_filter([
                                SiteSetting::getEmail(),
                            ])))
                            ->required(fn (Get $get): bool => (bool) $get(SiteSetting::CONTACT_FORWARD_ENABLED_KEY))
                            ->helperText('Mendukung satu atau beberapa email perusahaan. Tekan Enter, koma, atau spasi setelah mengetik setiap alamat email.')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $enabled = (bool) ($state[SiteSetting::CONTACT_FORWARD_ENABLED_KEY] ?? false);
        $emails = SiteSetting::normalizeEmailList($state[SiteSetting::CONTACT_FORWARD_EMAIL_KEY] ?? []);

        SiteSetting::setValue(
            SiteSetting::CONTACT_FORWARD_ENABLED_KEY,
            $enabled ? '1' : '0',
            'text'
        );

        SiteSetting::setValue(
            SiteSetting::CONTACT_FORWARD_EMAIL_KEY,
            implode(',', $emails),
            'text'
        );

        $this->form->fill([
            SiteSetting::CONTACT_FORWARD_ENABLED_KEY => $enabled,
            SiteSetting::CONTACT_FORWARD_EMAIL_KEY => $emails,
        ]);

        Notification::make()
            ->title('Pengaturan forward email berhasil disimpan!')
            ->body(
                $enabled && $emails !== []
                    ? 'Pesan kontak baru akan diteruskan ke: ' . implode(', ', $emails)
                    : 'Penerusan email saat ini dalam kondisi nonaktif.'
            )
            ->success()
            ->duration(4000)
            ->send();
    }

    public function sendTestEmail(): void
    {
        $state = $this->form->getState();
        $emails = SiteSetting::normalizeEmailList($state[SiteSetting::CONTACT_FORWARD_EMAIL_KEY] ?? []);

        if ($emails === []) {
            Notification::make()
                ->title('Belum ada alamat email tujuan')
                ->body('Masukkan minimal satu alamat email penerima yang valid terlebih dahulu.')
                ->warning()
                ->send();

            return;
        }

        try {
            $sampleMessage = new ContactMessage([
                'name' => auth()->user()?->name ?: 'Admin Uji Coba',
                'email' => auth()->user()?->email ?: SiteSetting::getEmail(),
                'message' => 'Ini adalah pesan uji coba untuk memastikan pengiriman forward email dari formulir Contact berjalan dengan baik.',
            ]);
            $sampleMessage->created_at = now();

            Mail::to($emails)->send(new ContactMessageForwarded($sampleMessage, isTest: true));

            Notification::make()
                ->title('Email uji coba berhasil dikirim')
                ->body('Terkirim ke ' . implode(', ', $emails) . ' melalui mailer "' . config('mail.default') . '".')
                ->success()
                ->duration(5000)
                ->send();
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim email uji coba forward pesan kontak.', [
                'recipients' => $emails,
                'error' => $e->getMessage(),
            ]);

            Notification::make()
                ->title('Gagal mengirim email uji coba')
                ->body($e->getMessage())
                ->danger()
                ->duration(6000)
                ->send();
        }
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->action('save'),

            Action::make('sendTestEmail')
                ->label('Kirim Email Uji Coba')
                ->icon('heroicon-o-envelope')
                ->color('gray')
                ->action('sendTestEmail'),
        ];
    }
}
