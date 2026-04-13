<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages;
use App\Filament\Resources\PartnerResource\RelationManagers;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationGroup = 'Manajemen Bisnis';

    protected static ?string $navigationLabel = 'Partner Bisnis';

    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return 'Partner Bisnis';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Partner Bisnis';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Partner')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Partner / Perusahaan (Opsional)')
                            ->maxLength(255)
                            ->helperText('Hanya digunakan untuk penamaan alternatif (Alt text) gambar.'),
                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo Partner')
                            ->image()
                            ->directory('partners')
                            ->required()
                            ->columnSpanFull()
                            ->helperText('Sangat disarankan logo dengan background transparan (PNG/SVG) putih atau warna kontras yang sesuai dengan background hijau.'),
                    ])->columns(1),

                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif Ditampilkan')
                            ->default(true),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->height(40)
                    ->extraImgAttributes(['class' => 'object-contain']),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Partner')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
