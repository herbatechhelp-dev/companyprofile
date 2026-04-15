<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestContactMessagesTable extends BaseWidget
{
    protected static ?string $heading = 'Pesan Kontak Terbaru';

    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ContactMessage::query()->latest('created_at')
            )
            ->defaultPaginationPageOption(5)
            ->paginated([5, 10])
            ->recordUrl(fn (ContactMessage $record): string => ContactMessageResource::getUrl('edit', ['record' => $record]))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('message')
                    ->label('Pesan')
                    ->limit(60),
                Tables\Columns\TextColumn::make('is_read')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Sudah dibaca' : 'Belum dibaca')
                    ->color(fn (bool $state): string => $state ? 'gray' : 'warning'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Masuk')
                    ->since()
                    ->sortable(),
            ]);
    }
}
