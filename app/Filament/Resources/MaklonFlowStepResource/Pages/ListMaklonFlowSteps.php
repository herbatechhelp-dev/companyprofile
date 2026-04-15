<?php

namespace App\Filament\Resources\MaklonFlowStepResource\Pages;

use App\Filament\Resources\MaklonFlowStepResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMaklonFlowSteps extends ListRecords
{
    protected static string $resource = MaklonFlowStepResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
