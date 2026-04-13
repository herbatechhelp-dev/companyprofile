<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyInfoResource\Pages;
use App\Models\CompanyInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompanyInfoResource extends Resource
{
    protected static ?string $model = CompanyInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Manajemen Perusahaan';

    public static function getModelLabel(): string
    {
        return 'Informasi Perusahaan';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Informasi Perusahaan';
    }

    public static function getNavigationLabel(): string
    {
        return 'Info Perusahaan';
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->whereNotIn('page', ['vision', 'mission', 'culture']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Halaman Perusahaan')
                    ->schema([
                        Forms\Components\Select::make('page')
                            ->label('Halaman')
                            ->options([
                                'our-group' => 'Grup Kami',
                                'sustainability' => 'Keberlanjutan',
                                'legal' => 'Legal',
                                'certification' => 'Sertifikasi',
                            ])
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('banner_image')
                            ->label('Gambar Banner')
                            ->image()
                            ->directory('company')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('icons')
                            ->label('Ikon Informasi')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul')
                                    ->required(),
                                Forms\Components\TextInput::make('icon') // bisa menggunakan heroicons
                                    ->label('Ikon')
                                    ->required(),
                                Forms\Components\Textarea::make('description')
                                    ->label('Deskripsi')
                                    ->required(),
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
                    ->label('Halaman')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'our-group' => 'primary',
                        'sustainability' => 'success',
                        'legal' => 'gray',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('banner_image')
                    ->label('Banner')
                    ->square(),
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
            'index' => Pages\ListCompanyInfos::route('/'),
            'create' => Pages\CreateCompanyInfo::route('/create'),
            'edit' => Pages\EditCompanyInfo::route('/{record}/edit'),
        ];
    }
}