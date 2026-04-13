<?php

namespace App\Filament\Resources\LandasanPerusahaanResource\Pages;

use App\Filament\Resources\LandasanPerusahaanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLandasanPerusahaan extends EditRecord
{
    protected static string $resource = LandasanPerusahaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
