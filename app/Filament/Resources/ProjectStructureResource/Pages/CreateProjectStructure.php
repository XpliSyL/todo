<?php

namespace App\Filament\Resources\ProjectStructureResource\Pages;

use App\Filament\Resources\ProjectStructureResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProjectStructure extends CreateRecord
{
    protected static string $resource = ProjectStructureResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
