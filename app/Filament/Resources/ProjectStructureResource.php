<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectStructureResource\Pages;
use App\Filament\Resources\ProjectStructureResource\Pages\CreateProjectStructure;
use App\Filament\Resources\ProjectStructureResource\Pages\EditProjectStructure;
use App\Filament\Resources\ProjectStructureResource\Pages\ListProjectStructures;
use App\Models\ProjectStructure;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;

class ProjectStructureResource extends Resource
{
    protected static ?string $model = ProjectStructure::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationLabel = 'Structure de Projet';
    protected static ?string $pluralModelLabel = 'Structures de Projet';
    protected static ?string $modelLabel = 'Structure de Projet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nom')
                    ->required(),
                SelectTree::make('parent_id')
                    ->relationship('parent', 'name', 'parent_id')
                    ->label('Structure de projet')
                    ->required(),
                TextInput::make('order')
                    ->label('Ordre')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('parent.name')
                    ->label('Niveau Parent')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('order')
                    ->label('Ordre')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Date de Création')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('parent_id')
                    ->label('Filtrer par Niveau Parent')
                    ->relationship('parent', 'name'),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectStructures::route('/'),
            'create' => Pages\CreateProjectStructure::route('/create'),
            'edit' => Pages\EditProjectStructure::route('/{record}/edit'),
        ];
    }
}
