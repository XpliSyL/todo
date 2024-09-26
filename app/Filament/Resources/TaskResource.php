<?php

namespace App\Filament\Resources;

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

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Tâche';
    protected static ?string $pluralModelLabel = 'Tâches';
    protected static ?string $modelLabel = 'Tâche';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                SelectTree::make('project_structure_id')
                    ->relationship('project_structure', 'name', 'parent_id')
                    ->label('Structure de projet')
                    ->required(),
                Select::make('user_id')
                    ->relationship('responsable', 'name')
                    ->label('Responsable')
                    ->required(),
                TextInput::make('title')
                    ->label('Titre')
                    ->required(),
                Textarea::make('details')
                    ->label('Détail')
                    ->rows(5),
                Select::make('task_types_id')
                    ->relationship('type', 'type')
                    ->label('Type')
                    ->required()
                    ->createOptionForm([
                        TextInput::make('type')
                    ]),
                DatePicker::make('due_date')
                    ->label('Date d’échéance')
                    ->required(),
                Select::make('status')
                    ->label('État')
                    ->options(TaskStatus::class)
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('responsable.name')
                    ->label('Responsable')
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable(),
                TextColumn::make('project_structure.name')
                    ->label('Niveau de Structure')
                    ->searchable(),
                TextColumn::make('due_date')
                    ->label('Date d’échéance')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('État')
                    ->searchable()
                    ->badge(),
            ])
            ->filters([
                // Filtres par responsable ou par niveau de structure
                SelectFilter::make('responsable_id')
                    ->label('Filtrer par Responsable')
                    ->relationship('responsable', 'name'),
                SelectFilter::make('project_structure_id')
                    ->label('Filtrer par Niveau de Structure')
                    ->relationship('project_structure', 'name'),
                SelectFilter::make('status')
                    ->options(TaskStatus::class)
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
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
