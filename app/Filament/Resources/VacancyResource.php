<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VacancyResource\Pages;
use App\Filament\Resources\VacancyResource\RelationManagers;
use App\Models\Vacancy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VacancyResource extends Resource
{
    protected static ?string $navigationGroup = 'Manajemen Konten';

    public static function getModelLabel(): string
    {
        return 'Lowongan';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Lowongan';
    }

    public static function getNavigationLabel(): string
    {
        return 'Karir';
    }
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Pekerjaan')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Posisi')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'edit') return;
                                $set('slug', \Illuminate\Support\Str::slug($state));
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('division')
                            ->label('Departemen / Divisi'),
                        Forms\Components\TextInput::make('location')
                            ->label('Lokasi')
                            ->default('Head Office'),
                        Forms\Components\Select::make('type')
                            ->label('Tipe Pekerjaan')
                            ->options([
                                'Penuh Waktu' => 'Penuh Waktu',
                                'Paruh Waktu' => 'Paruh Waktu',
                                'Kontrak' => 'Kontrak',
                                'Magang' => 'Magang',
                                'Lepas Waktu' => 'Lepas Waktu',
                            ])
                            ->default('Penuh Waktu')
                            ->required(),
                        Forms\Components\TextInput::make('application_link')
                            ->label('Email / URL Lamaran')
                            ->placeholder('https://... or mailto:...')
                            ->helperText('Masukkan URL Google Form atau "mailto:email@contoh.com"'),
                        Forms\Components\DatePicker::make('closing_date')
                            ->label('Tanggal Penutupan'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif / Diterbitkan')
                            ->default(true)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Deskripsi & Persyaratan Pekerjaan')
                    ->schema([
                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi Pekerjaan')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('requirements')
                            ->label('Persyaratan')
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('division')
                    ->label('Divisi')
                    ->searchable()
                    ->sortable()
                    ->badge(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Full-time' => 'success',
                        'Internship' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->icon('heroicon-o-map-pin'),
                Tables\Columns\TextColumn::make('closing_date')
                    ->label('Tutup Pada')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Aktif'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'Full-time' => 'Full-time',
                        'Part-time' => 'Part-time',
                        'Contract' => 'Contract',
                        'Internship' => 'Internship',
                        'Freelance' => 'Freelance',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVacancies::route('/'),
            'create' => Pages\CreateVacancy::route('/create'),
            'edit' => Pages\EditVacancy::route('/{record}/edit'),
        ];
    }
}
