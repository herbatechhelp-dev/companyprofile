<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleCategoryResource\Pages;
use App\Filament\Resources\ArticleCategoryResource\RelationManagers;
use App\Models\ArticleCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticleCategoryResource extends Resource
{
    protected static ?string $model = ArticleCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Manajemen Konten';

    public static function getModelLabel(): string
    {
        return 'Kategori Artikel';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Kategori Artikel';
    }

    public static function getNavigationLabel(): string
    {
        return 'Kategori Artikel';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Umum')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ])->columns(2),

                Forms\Components\Section::make('Konfigurasi Hero')
                    ->description('Konfigurasi bagian banner/hero untuk halaman kategori ini')
                    ->schema([
                        Forms\Components\TextInput::make('banner_title')
                            ->label('Judul Banner')
                            ->maxLength(255)
                            ->helperText('Ganti nama kategori default di banner'),
                        Forms\Components\RichEditor::make('banner_content')
                            ->label('Konten Banner')
                            ->helperText('Deskripsi tambahan untuk banner'),
                        Forms\Components\FileUpload::make('banner_image')
                            ->label('Gambar Banner')
                            ->image()
                            ->directory('article-categories')
                            ->helperText('Ukuran yang disarankan: 1920x600px'),
                        Forms\Components\FileUpload::make('banner_video')
                            ->label('Video Banner')
                            ->directory('article-categories')
                            ->acceptedFileTypes(['video/mp4', 'video/webm'])
                            ->helperText('Format MP4 atau WebM disarankan'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
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
            'index' => Pages\ListArticleCategories::route('/'),
            'create' => Pages\CreateArticleCategory::route('/create'),
            'edit' => Pages\EditArticleCategory::route('/{record}/edit'),
        ];
    }
}
