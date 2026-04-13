<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Manajemen Konten';

    public static function getModelLabel(): string
    {
        return 'Artikel';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Artikel';
    }

    public static function getNavigationLabel(): string
    {
        return 'Artikel';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Artikel')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'edit') return;
                                $set('slug', Str::slug($state));
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('article_category_id')
                            ->label('Kategori')
                            ->relationship('articleCategory', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\FileUpload::make('thumbnail')
                            ->image()
                            ->directory('articles')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('content')
                            ->label('Konten')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Tanggal Terbit')
                            ->default(now()) // Tambahkan default value
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->square(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('articleCategory.name')
                    ->label('Kategori')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Status Publikasi')
                    ->dateTime()
                    ->sortable()
                    ->color(fn ($record) => $record->isPublished() ? 'success' : 'danger')
                    ->description(fn ($record) => $record->isPublished() ? 'Terbit' : 'Belum Terbit'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('article_category_id')
                    ->relationship('articleCategory', 'name')
                    ->label('Category'),
                Tables\Filters\Filter::make('published')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('published_at')->where('published_at', '<=', now())),
                Tables\Filters\Filter::make('not_published')
                    ->query(fn (Builder $query): Builder => $query->whereNull('published_at')->orWhere('published_at', '>', now())),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('publish')
                    ->action(function (Article $record) {
                        $record->update(['published_at' => now()]);
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->hidden(fn (Article $record) => $record->isPublished()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('publish')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['published_at' => now()]);
                            }
                        })
                        ->requiresConfirmation()
                        ->color('success')
                        ->icon('heroicon-o-check'),
                ]),
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}