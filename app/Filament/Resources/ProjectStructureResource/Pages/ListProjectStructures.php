<?php

namespace App\Filament\Resources\ProjectStructureResource\Pages;

use App\Filament\Resources\ProjectStructureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectStructures extends ListRecords
{
    protected static string $resource = ProjectStructureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
