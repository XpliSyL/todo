<?php

namespace App\Filament\Resources\ProjectStructureResource\Pages;

use App\Filament\Resources\ProjectStructureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectStructure extends EditRecord
{
    protected static string $resource = ProjectStructureResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
