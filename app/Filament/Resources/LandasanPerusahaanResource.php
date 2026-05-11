<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LandasanPerusahaanResource\Pages;
use App\Models\CompanyInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LandasanPerusahaanResource extends Resource
{
    protected static ?string $model = CompanyInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Manajemen Perusahaan';

    public static function getModelLabel(): string
    {
        return 'Landasan Perusahaan';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Landasan Perusahaan';
    }

    public static function getNavigationLabel(): string
    {
        return 'Visi, Misi & Kultur';
    }

    public static function getEloquentQuery(): Builder
    {
        // Hanya tampilkan data vision, mission, culture, dan tagline di table ini
        return parent::getEloquentQuery()->whereIn('page', ['vision', 'mission', 'culture', 'tagline']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Inti Perusahaan')
                    ->schema([
                        Forms\Components\Select::make('page')
                            ->label('Kategori')
                            ->options([
                                'vision' => 'Visi',
                                'mission' => 'Misi',
                                'culture' => 'Kultur Perusahaan',
                                'tagline' => 'Banner Tagline (THINK BIG)',
                            ])
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Tampilan')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('banner_image')
                            ->label('Gambar/Ikon Penunjang')
                            ->image()
                            ->directory('company')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi')
                            ->nullable()
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('icons')
                            ->label('Daftar Poin (Cth: Poin Misi / Kultur PRI)')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul/Inisial Huruf')
                                    ->required(),
                                Forms\Components\TextInput::make('icon')
                                    ->label('Ikon (Opsional)'),
                                Forms\Components\Textarea::make('description')
                                    ->label('Deskripsi Poin'),
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('page')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'vision' => 'info',
                        'mission' => 'warning',
                        'culture' => 'danger',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
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
            'index' => Pages\ListLandasanPerusahaans::route('/'),
            'create' => Pages\CreateLandasanPerusahaan::route('/create'),
            'edit' => Pages\EditLandasanPerusahaan::route('/{record}/edit'),
        ];
    }
}
