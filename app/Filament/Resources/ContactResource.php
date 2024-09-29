<?php

namespace App\Filament\Resources;

use App\Filament\Exports\ContactExporter;
use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use App\Models\Entity;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\TextFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ViewAction;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Prénom')
                    ->required(),
                TextInput::make('last_name')
                    ->label('Nom')
                    ->required(),
                TextInput::make('job_title')
                    ->label('Fonction')
                    ->required(),
                Select::make('entity_id')
                    ->relationship('entity', 'name')
                    ->label('Entité')
                    ->createOptionForm([
                        TextInput::make('name')
                    ])
                    ->searchable()
                    ->preload(),
                Select::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->createOptionForm([
                        TextInput::make('name')
                    ])
                    ->preload()
                    ->label('Étiquettes'),
                TextInput::make('phone')
                    ->label('Téléphone'),
                TextInput::make('email')
                    ->label('Email'),
                Textarea::make('note')
                    ->label('Note'),
                Textarea::make('links')
                    ->label('Lien'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(ContactExporter::class)
            ])
            ->columns([
                TextColumn::make('name')
                    ->label('Prénom')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->label('Nom')
                    ->searchable(['last_name', 'email']),
                TextColumn::make('entity.name')
                    ->label('Entité')
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('tag_id')
                    ->label('Filtrer par étiquette')
                    ->relationship('tags', 'name'),
                SelectFilter::make('entity_id')
                    ->label('Filtrer par entité')
                    ->relationship('entity', 'name'),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->exporter(ContactExporter::class),
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
