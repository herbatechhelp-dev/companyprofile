<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeSectionResource\Pages;
use App\Models\HomeSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HomeSectionResource extends Resource
{
    protected static ?string $model = HomeSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationGroup = 'Manajemen Situs';

    public static function getModelLabel(): string
    {
        return 'Bagian Halaman';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Bagian Halaman';
    }

    public static function getNavigationLabel(): string
    {
        return 'Bagian Hero & Konten';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Konfigurasi Bagian Halaman')
                    ->schema([
                        Forms\Components\Select::make('section')
                            ->label('Bagian')
                            ->options([
                                'hero' => 'Hero Beranda',
                                'about' => 'Tentang Beranda',
                                'products' => 'Hero Halaman Produk',
                                'research' => 'Riset Beranda',
                                'facilities' => 'Hero Halaman Fasilitas',
                                'articles' => 'Hero Halaman Artikel',
                                'contact' => 'Hero Halaman Kontak',
                                'our-group' => 'Hero Halaman Grup Kami',
                                'sustainability' => 'Hero Halaman Keberlanjutan',
                                'legal' => 'Hero Halaman Legal',
                                'certification' => 'Hero Halaman Sertifikasi',
                            ])
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('content')
                            ->label('Konten'),
                        Forms\Components\TextInput::make('video_url')
                            ->label('URL Video')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('background_image')
                            ->label('Gambar Latar Belakang')
                            ->image()
                            ->directory('home')
                            ->helperText('Ukuran yang disarankan: 1920x1080px untuk kualitas optimal'),
                        Forms\Components\FileUpload::make('background_video')
                            ->label('Video Latar Belakang')
                            ->directory('home')
                            ->acceptedFileTypes(['video/mp4', 'video/webm'])
                            ->helperText('Format MP4 atau WebM disarankan'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->required()
                            ->default(true),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('section')
                    ->label('Bagian')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'hero' => 'danger',
                        'about' => 'primary',
                        'products' => 'success',
                        'research' => 'warning',
                        'facilities' => 'info',
                        'articles' => 'gray',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHomeSections::route('/'),
            'create' => Pages\CreateHomeSection::route('/create'),
            'edit' => Pages\EditHomeSection::route('/{record}/edit'),
        ];
    }
}