<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;

use App\Enums\TaskStatus;
use App\Filament\Exports\TaskExporter;
use App\Filament\Resources\TaskResource;
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
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Illuminate\Database\Eloquent\Builder;

class LatestTasks extends BaseWidget

{

    protected static ?string $model = Task::class;

    protected int | string | array $columnSpan = 'full';
    protected static ?string $navigationLabel = 'Vos tâche';
    protected static ?string $pluralModelLabel = 'Vos tâches';
    protected static ?string $modelLabel = 'Vos tâches';

    // Needed by InteractsWithPageTable trait.
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
                TextColumn::make('name')
                    ->label('Titre')
                    ->searchable(),
                TextColumn::make('project_structure.name')
                    ->label('Niveau de Structure')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('responsable.name')
                    ->label('Responsable')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('due_date')
                    ->label('Date d’échéance')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('État')
                    ->searchable()
                    ->badge(),
            ])->filters([
                //Todo set à faire par défaut
                //ajouter filtre user par défaut le sien, et tout les autres
                //
                // Filter::make('tree')
                // ->form([
                //     SelectTree::make('categories')
                //     ->relationship('categories', 'name', 'parent_id')
                //     ->independent(false)
                //         ->enableBranchNode(),
                // ])
                // ->query(function (Builder $query, array $data) {
                //     return $query->when($data['categories'],
                //         function ($query, $categories) {
                //             return $query->whereHas('categories', fn($query) => $query->whereIn('id', $categories));
                //         }
                //     );
                // })
                // ->indicateUsing(function (array $data): ?string {
                //     if (! $data['categories']) {
                //         return null;
                //     }

                //     return __('Categories') . ': ' . implode(', ', Category::whereIn('id', $data['categories'])->get()->pluck('name')->toArray());
                // })

                SelectFilter::make('project_structure_id')
                    ->label('Filtrer par Niveau de Structure')
                    ->relationship('project_structure', 'name'),
                SelectFilter::make('responsable_id')
                    ->label('Filtrer par Responsable')
                    ->relationship('responsable', 'name'),
                SelectFilter::make('status')
                    ->options(TaskStatus::class)
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
                Action::make('view')
                    ->action(function (Task $record) {
                        dd($record);
                    })
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->exporter(TaskExporter::class),
                    DeleteBulkAction::make(),
                ]),
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
