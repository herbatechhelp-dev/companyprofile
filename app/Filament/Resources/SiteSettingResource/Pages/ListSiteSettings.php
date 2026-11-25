<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Pages\ContactForwardSettings;
use App\Filament\Resources\SiteSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSiteSettings extends ListRecords
{
    protected static string $resource = SiteSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('contactForwardSettings')
                ->label('Forward Email Pesan')
                ->icon('heroicon-o-paper-airplane')
                ->color('gray')
                ->url(ContactForwardSettings::getUrl()),
            Actions\CreateAction::make(),
        ];
    }
}
