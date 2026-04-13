<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = 'Manajemen Situs';

    public static function getModelLabel(): string
    {
        return 'Pengaturan Situs';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Pengaturan Situs';
    }

    public static function getNavigationLabel(): string
    {
        return 'Pengaturan';
    }

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pengaturan')
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('key')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->label('Kunci Pengaturan')
                                    ->helperText('Contoh: company_name, logo, tagline, address, dll.'),
                                
                                Forms\Components\Select::make('type')
                                    ->options([
                                        'text' => 'Teks',
                                        'textarea' => 'Area Teks',
                                        'image' => 'Gambar',
                                        'number' => 'Angka',
                                        'url' => 'URL',
                                        'email' => 'Email',
                                        'phone' => 'Telepon',
                                    ])
                                    ->required()
                                    ->live()
                                    ->label('Tipe Nilai')
                                    ->helperText('Pilih tipe nilai untuk setting ini.'),
                            ])
                            ->columns(2),
                        
                        // Dynamic field based on type
                        Forms\Components\Group::make()
                            ->schema(function (Forms\Get $get) {
                                $type = $get('type');
                                
                                switch ($type) {
                                    case 'textarea':
                                        return [
                                            Forms\Components\Textarea::make('value')
                                                ->label('Konten Nilai')
                                                ->required()
                                                ->rows(4)
                                                ->columnSpanFull()
                                                ->helperText('Masukkan konten teks panjang.')
                                        ];
                                        
                                    case 'image':
                                        return [
                                            Forms\Components\FileUpload::make('value')
                                                ->label('File Gambar')
                                                ->image()
                                                ->directory('settings')
                                                ->visibility('public')
                                                ->preserveFilenames()
                                                ->maxSize(2048)
                                                ->required()
                                                ->columnSpanFull()
                                                ->helperText('Upload gambar (maksimal 2MB). Format: JPG, PNG, SVG.')
                                        ];
                                        
                                    case 'number':
                                        return [
                                            Forms\Components\TextInput::make('value')
                                                ->label('Nilai Angka')
                                                ->numeric()
                                                ->required()
                                                ->columnSpanFull()
                                                ->helperText('Masukkan angka (contoh untuk kecepatan: 30).')
                                        ];
                                        
                                    case 'url':
                                        return [
                                            Forms\Components\TextInput::make('value')
                                                ->label('Alamat URL')
                                                ->url()
                                                ->required()
                                                ->columnSpanFull()
                                                ->helperText('Masukkan URL lengkap (contoh: https://example.com).')
                                        ];
                                        
                                    case 'email':
                                        return [
                                            Forms\Components\TextInput::make('value')
                                                ->label('Alamat Email')
                                                ->email()
                                                ->required()
                                                ->columnSpanFull()
                                                ->helperText('Masukkan alamat email yang valid.')
                                        ];
                                        
                                    case 'phone':
                                        return [
                                            Forms\Components\TextInput::make('value')
                                                ->label('Nomor Telepon')
                                                ->tel()
                                                ->required()
                                                ->columnSpanFull()
                                                ->helperText('Masukkan nomor telepon.')
                                        ];
                                        
                                    default: // text
                                        return [
                                            Forms\Components\TextInput::make('value')
                                                ->label('Nilai Teks')
                                                ->required()
                                                ->maxLength(255)
                                                ->columnSpanFull()
                                                ->helperText('Masukkan nilai teks.')
                                        ];
                                }
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable()
                    ->sortable()
                    ->label('Kunci')
                    ->weight('medium'),
                
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'text' => 'gray',
                        'textarea' => 'blue',
                        'image' => 'success',
                        'url' => 'primary',
                        'email' => 'warning',
                        'phone' => 'info',
                        default => 'gray',
                    })
                    ->sortable()
                    ->label('Tipe'),
                
                Tables\Columns\TextColumn::make('value')
                    ->label('Nilai')
                    ->limit(50)
                    ->wrap()
                    ->formatStateUsing(function ($state, SiteSetting $record) {
                        if ($record->type === 'image' && $state) {
                            return '📷 ' . basename($state);
                        }
                        return $state;
                    }),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Terakhir Diperbarui')
                    ->since(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'text' => 'Teks',
                        'textarea' => 'Area Teks',
                        'image' => 'Gambar',
                        'url' => 'URL',
                        'email' => 'Email',
                        'phone' => 'Telepon',
                    ])
                    ->label('Filter berdasarkan Tipe'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->defaultSort('key');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}