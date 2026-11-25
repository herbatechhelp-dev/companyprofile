<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Pages\ContactForwardSettings;
use App\Filament\Resources\ContactMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactMessages extends ListRecords
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('contactForwardSettings')
                ->label('Pengaturan Forward Email')
                ->icon('heroicon-o-paper-airplane')
                ->color('gray')
                ->url(ContactForwardSettings::getUrl()),
            Actions\CreateAction::make(),
        ];
    }
}
