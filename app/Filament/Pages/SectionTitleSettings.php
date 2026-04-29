<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SectionTitleSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationGroup = 'Manajemen Situs';

    protected static ?string $navigationLabel = 'Judul & Caption';

    protected static ?string $title = 'Pengaturan Judul & Caption Halaman Utama';

    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.section-title-settings';

    // Form state
    public ?array $data = [];

    public function mount(): void
    {
        $keys = [
            'services_title', 'services_subtitle',
            'materials_title',
            'partners_title',
            'why_us_title', 'why_us_subtitle',
            'maklon_title', 'maklon_subtitle',
            'maklon_badge', 'maklon_badge_desc',
        ];

        $formData = [];
        foreach ($keys as $key) {
            $formData[$key] = SiteSetting::getValue($key, '');
        }

        $this->form->fill($formData);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                // ── LAYANAN UNGGULAN ──────────────────────────────
                Section::make('🛠️  Layanan Unggulan Kami')
                    ->description('Section yang menampilkan daftar layanan/jasa utama perusahaan.')
                    ->schema([
                        TextInput::make('services_title')
                            ->label('Judul Section')
                            ->placeholder('Layanan Unggulan Kami')
                            ->maxLength(100)
                            ->required(),
                        Textarea::make('services_subtitle')
                            ->label('Caption / Deskripsi')
                            ->placeholder('Kami menawarkan berbagai solusi manufaktur ...')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),

                // ── PRODUK YANG KAMI HASILKAN ─────────────────────
                Section::make('📦  Produk yang Kami Hasilkan')
                    ->description('Section yang menampilkan kategori produk / material.')
                    ->schema([
                        TextInput::make('materials_title')
                            ->label('Judul Section')
                            ->placeholder('Produk yang Kami Hasilkan')
                            ->maxLength(100)
                            ->required(),
                    ])
                    ->columns(1)
                    ->collapsible(),

                // ── PARTNER / CLIENT ──────────────────────────────
                Section::make('🤝  Partner & Klien')
                    ->description('Teks di atas marquee logo partner.')
                    ->schema([
                        TextInput::make('partners_title')
                            ->label('Label Partner')
                            ->placeholder('TELAH DIPERCAYA OLEH PERUSAHAAN TERNAMA')
                            ->maxLength(150)
                            ->required(),
                    ])
                    ->columns(1)
                    ->collapsible(),

                // ── MENGAPA HARUS KAMI ────────────────────────────
                Section::make('⭐  Mengapa Harus Kami?')
                    ->description('Section keunggulan / alasan memilih perusahaan.')
                    ->schema([
                        TextInput::make('why_us_title')
                            ->label('Judul Section')
                            ->placeholder('Mengapa Harus Kami?')
                            ->maxLength(100)
                            ->required(),
                        Textarea::make('why_us_subtitle')
                            ->label('Caption / Deskripsi')
                            ->placeholder('Dedikasi kami pada kualitas dan inovasi ...')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),

                // ── ALUR MAKLON ───────────────────────────────────
                Section::make('🔄  Alur Maklon')
                    ->description('Section langkah-langkah proses kerjasama maklon.')
                    ->schema([
                        TextInput::make('maklon_title')
                            ->label('Judul Section')
                            ->placeholder('Alur Maklon')
                            ->maxLength(100)
                            ->required(),
                        Textarea::make('maklon_subtitle')
                            ->label('Caption / Deskripsi')
                            ->placeholder('Langkah-langkah kerjasama maklon kami ...')
                            ->rows(2)
                            ->columnSpanFull(),
                        TextInput::make('maklon_badge')
                            ->label('Teks Badge')
                            ->placeholder('Proses berjalan terarah')
                            ->maxLength(80),
                        Textarea::make('maklon_badge_desc')
                            ->label('Deskripsi Badge')
                            ->placeholder('Setiap tahap dirancang berurutan ...')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),

            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $values = $this->form->getState();

        $typeMap = [
            'services_title'   => 'text',
            'services_subtitle'=> 'textarea',
            'materials_title'  => 'text',
            'partners_title'   => 'text',
            'why_us_title'     => 'text',
            'why_us_subtitle'  => 'textarea',
            'maklon_title'     => 'text',
            'maklon_subtitle'  => 'textarea',
            'maklon_badge'     => 'text',
            'maklon_badge_desc'=> 'textarea',
        ];

        foreach ($values as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'type' => $typeMap[$key] ?? 'text']
            );
        }

        Notification::make()
            ->title('✅ Berhasil disimpan!')
            ->body('Judul dan caption halaman utama telah diperbarui.')
            ->success()
            ->duration(4000)
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->action('save'),
        ];
    }
}
