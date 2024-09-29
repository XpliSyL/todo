<?php

namespace App\Filament\Exports;

use App\Models\Task;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TaskExporter extends Exporter
{
    protected static ?string $model = Task::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('project_structure.name'),
            ExportColumn::make('responsable.name')->label('Responsable'),
            ExportColumn::make('type.type')->label('Type de tâche'),
            ExportColumn::make('name')->label('Titre'),
            ExportColumn::make('details')->label('Détail'),
            ExportColumn::make('status')->getStateUsing(fn(Task $record) => $record->status->getLabel()),
            ExportColumn::make('due_date')->label("Date d'échéance"),
            ExportColumn::make('contact.name')->label('Contact'),
            ExportColumn::make('deleted_at'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your task export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
