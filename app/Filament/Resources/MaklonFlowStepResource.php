<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaklonFlowStepResource\Pages;
use App\Models\MaklonFlowStep;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MaklonFlowStepResource extends Resource
{
    protected static ?string $model = MaklonFlowStep::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = 'Manajemen Maklon';

    public static function getModelLabel(): string
    {
        return 'Langkah Maklon';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Langkah Maklon';
    }

    public static function getNavigationLabel(): string
    {
        return 'Alur Maklon';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Langkah Maklon')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Langkah')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi Langkah'),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaklonFlowSteps::route('/'),
            'create' => Pages\CreateMaklonFlowStep::route('/create'),
            'edit' => Pages\EditMaklonFlowStep::route('/{record}/edit'),
        ];
    }
}
