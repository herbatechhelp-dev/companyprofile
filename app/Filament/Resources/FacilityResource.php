<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacilityResource\Pages;
use App\Filament\Resources\FacilityResource\RelationManagers;
use App\Models\Facility;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str; // TAMBAHKAN INI

class FacilityResource extends Resource
{
    protected static ?string $model = Facility::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Manajemen Situs';

    public static function getModelLabel(): string
    {
        return 'Fasilitas';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Fasilitas';
    }

    public static function getNavigationLabel(): string
    {
        return 'Fasilitas';
    }

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Fasilitas')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Masukkan nama fasilitas')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'edit') return;
                                $set('slug', Str::slug($state));
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('type')
                            ->label('Tipe')
                            ->options([
                                'Kegiatan' => 'Kegiatan',
                                'Proses' => 'Proses',
                            ])
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'blockquote', 'bulletList', 'orderedList',
                                'link', 'undo', 'redo'
                            ])
                            ->placeholder('Gambarkan fasilitas ini...'),

                        Forms\Components\FileUpload::make('image')
                            ->label('Gambar Fasilitas')
                            ->image()
                            ->directory('facilities')
                            ->maxSize(2048)
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('450')
                            ->columnSpanFull()
                            ->helperText('Unggah gambar fasilitas (maks: 2MB, rasio yang disarankan: 16:9)'),

                        Forms\Components\TextInput::make('location')
                            ->label('Lokasi')
                            ->maxLength(255)
                            ->placeholder('misal, Gedung A, Lantai 3'),

                        Forms\Components\TextInput::make('capacity')
                            ->label('Kapasitas')
                            ->numeric()
                            ->minValue(1)
                            ->placeholder('misal, 50'),

                        Forms\Components\TextInput::make('order')
                            ->label('Urutan Tampilan')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Angka lebih rendah muncul pertama'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Fitur & Fasilitas Tambahan')
                    ->schema([
                        Forms\Components\Repeater::make('features')
                            ->label('Fitur')
                            ->schema([
                                Forms\Components\TextInput::make('feature')
                                    ->label('Fitur')
                                    ->required()
                                    ->placeholder('misal, AC, Wi-Fi, Proyektor, dll.')
                                    ->maxLength(100)
                            ])
                            ->defaultItems(0)
                            ->addActionLabel('Tambah Fitur')
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['feature'] ?? null)
                            ->columnSpanFull()
                            ->helperText('Daftar fitur utama dan fasilitas dari fasilitas ini'),
                    ]),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->required()
                            ->default(true)
                            ->helperText('Hanya fasilitas aktif yang akan ditampilkan di situs web'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->square()
                    ->size(60),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->description(fn (Facility $record): string => $record->description ? Str::limit(strip_tags($record->description), 50) : 'Tidak ada deskripsi'),

                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->colors([
                        'primary' => 'Kegiatan',
                        'success' => 'Proses',
                    ])
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->placeholder('Not specified'),

                Tables\Columns\TextColumn::make('capacity')
                    ->label('Kapasitas')
                    ->numeric()
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(fn ($state) => $state ? $state . ' orang' : 'Tidak ditentukan')
                    ->placeholder('Tidak ditentukan'),

                Tables\Columns\TextColumn::make('features')
                    ->label('Fitur')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) return 'Tidak ada fitur';
                        return collect($state)->pluck('feature')->implode(', ');
                    })
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable()
                    ->toggleable()
                    ->label('Urutan'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')
                    ->label('Fasilitas Aktif')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),

                Tables\Filters\Filter::make('has_capacity')
                    ->label('Dengan Kapasitas')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('capacity')),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil')
                    ->color('primary'),

                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->color('danger'),

                Tables\Actions\RestoreAction::make()
                    ->icon('heroicon-o-arrow-path'),

                Tables\Actions\ForceDeleteAction::make()
                    ->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->icon('heroicon-o-trash'),
                    Tables\Actions\RestoreBulkAction::make()
                        ->icon('heroicon-o-arrow-path'),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->icon('heroicon-o-trash'),
                ]),
            ])
            ->defaultSort('order', 'asc')
            ->reorderable('order')
            ->emptyStateHeading('Belum ada fasilitas')
            ->emptyStateDescription('Buat fasilitas pertama Anda untuk memulai.')
            ->emptyStateIcon('heroicon-o-building-office')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Buat Fasilitas')
                    ->icon('heroicon-o-plus'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFacilities::route('/'),
            'create' => Pages\CreateFacility::route('/create'),
            'edit' => Pages\EditFacility::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'location', 'description'];
    }
}