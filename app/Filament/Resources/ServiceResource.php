<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'Manajemen Bisnis';

    public static function getModelLabel(): string
    {
        return 'Layanan Unggulan';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Layanan Unggulan';
    }

    public static function getNavigationLabel(): string
    {
        return 'Layanan Kami';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Layanan')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Nama Layanan / Judul')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('image')
                            ->label('Gambar Layanan (Opsional)')
                            ->image()
                            ->directory('services')
                            ->helperText('Gambar representasi layanan (opsional).'),
                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi & Poin Poin')
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold', 'italic', 'bulletList', 'orderedList', 'h2', 'h3', 'undo', 'redo'
                            ]),
                    ])->columns(2),
                
                Forms\Components\Section::make('Sub Konten / Poin Layanan Turunan')
                    ->description('Tambahkan poin-poin detail atau sub-layanan di bawah layanan utama ini. Contoh: jika layanan adalah "Perizinan Produk", maka sub-kontennya bisa berupa "Registrasi BPOM", "Sertifikasi Halal", dll.')
                    ->schema([
                        Forms\Components\Repeater::make('sub_contents')
                            ->label('')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul Sub Layanan')
                                    ->placeholder('Contoh: Registrasi BPOM'),
                                Forms\Components\FileUpload::make('image')
                                    ->label('Gambar Sub Layanan (Opsional)')
                                    ->image()
                                    ->directory('services/sub'),
                                Forms\Components\RichEditor::make('description')
                                    ->label('Deskripsi Sub Layanan')
                                    ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'undo', 'redo'])
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->addActionLabel('+ Tambah Sub Konten')
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
                    ->label('Nama Layanan')
                    ->searchable(),
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
            ])
            ->defaultSort('sort_order', 'asc');
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
