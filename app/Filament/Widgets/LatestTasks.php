<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;

use App\Enums\TaskStatus;
use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\Pages\CreateTask;
use App\Filament\Resources\TaskResource\Pages\EditTask;
use App\Filament\Resources\TaskResource\Pages\ListTasks;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\ProjectStructure;
use App\Models\Task;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Tables\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LatestTasks extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    // Query to fetch tasks that are not done, ordered by the latest first
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Task::query()
                    ->where('status', '!=', 'done')
                    ->whereUserId(auth()->id())
                    ->orderBy('updated_at', 'desc')
            )
            ->columns([
                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable(),
                TextColumn::make('project_structure.name')
                    ->label('Niveau de Structure')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('responsable.name')
                    ->label('Responsable')
                    ->searchable(),
                TextColumn::make('due_date')
                    ->label('Date d’échéance')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('État')
                    ->searchable()
                    ->badge(),
            ])->filters([
                SelectFilter::make('project_structure_id')
                    ->label('Filtrer par Niveau de Structure')
                    ->relationship('project_structure', 'name'),
                SelectFilter::make('status')
                    ->options(TaskStatus::class)
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
