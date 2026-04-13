<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialResource\Pages;
use App\Models\Material;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $navigationGroup = 'Manajemen Bisnis';

    public static function getModelLabel(): string
    {
        return 'Bahan Material';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Bahan Material';
    }

    public static function getNavigationLabel(): string
    {
        return 'Bahan yang Kami Gunakan';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Kategori Bahan')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Nama Kategori Bahan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Obat Bahan Alam'),
                        Forms\Components\FileUpload::make('image')
                            ->label('Gambar Header Kategori (Opsional)')
                            ->image()
                            ->directory('materials'),
                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi Kategori (Opsional)')
                            ->columnSpanFull()
                            ->toolbarButtons(['bold', 'italic', 'bulletList', 'undo', 'redo']),
                    ])->columns(2),

                Forms\Components\Section::make('Daftar Item Bahan')
                    ->description('Tambahkan bahan-bahan yang termasuk dalam kategori ini. Setiap item bisa memiliki nama dan gambar.')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->label('')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Bahan')
                                    ->placeholder('Contoh: Soft Candy'),
                                Forms\Components\FileUpload::make('image')
                                    ->label('Gambar Bahan')
                                    ->image()
                                    ->directory('materials/items'),
                            ])
                            ->columns(2)
                            ->addActionLabel('+ Tambah Item Bahan')
                            ->collapsible()
                            ->cloneable()
                            ->reorderable()
                            ->columnSpanFull(),
                    ])->collapsible(),

                Forms\Components\Section::make('Pengaturan Tampilan')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif Ditampilkan')
                            ->default(true)
                            ->required(),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->helperText('Semakin kecil angka, semakin awal ditampilkan.'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Nama Kategori Bahan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('items')
                    ->label('Jumlah Item')
                    ->formatStateUsing(fn ($state) => is_array($state) ? count($state) . ' item' : '0 item'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diupdate')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'edit'   => Pages\EditMaterial::route('/{record}/edit'),
        ];
    }
}
