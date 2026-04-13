<?php

namespace App\Filament\Resources\LandasanPerusahaanResource\Pages;

use App\Filament\Resources\LandasanPerusahaanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLandasanPerusahaans extends ListRecords
{
    protected static string $resource = LandasanPerusahaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
