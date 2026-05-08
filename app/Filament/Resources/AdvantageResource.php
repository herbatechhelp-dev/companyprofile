<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdvantageResource\Pages;
use App\Filament\Resources\AdvantageResource\RelationManagers;
use App\Models\Advantage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdvantageResource extends Resource
{
    protected static ?string $model = Advantage::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'Manajemen Bisnis';

    protected static ?string $navigationLabel = 'Keunggulan Kami';

    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return 'Keunggulan Kami';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Keunggulan Kami';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Keunggulan')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Keunggulan')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('icon_image')
                            ->label('Gambar Icon (Opsional)')
                            ->image()
                            ->directory('advantages')
                            ->helperText('Gunakan icon transparan (PNG/SVG) untuk hasil terbaik.'),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Singkat')
                            ->nullable()
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('points')
                            ->label('Daftar Poin Keunggulan (Opsional)')
                            ->schema([
                                Forms\Components\TextInput::make('point')
                                    ->label('Poin')
                                    ->required()
                            ])
                            ->columnSpanFull()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['point'] ?? null),
                    ])->columns(2),

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
                Tables\Columns\ImageColumn::make('icon_image')
                    ->label('Icon')
                    ->square(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50),
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
            'index' => Pages\ListAdvantages::route('/'),
            'create' => Pages\CreateAdvantage::route('/create'),
            'edit' => Pages\EditAdvantage::route('/{record}/edit'),
        ];
    }
}
