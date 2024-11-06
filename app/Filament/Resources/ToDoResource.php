<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ToDoResource\Pages;
use App\Filament\Resources\ToDoResource\RelationManagers;
use App\Models\ToDo;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ToDoResource extends Resource
{
    protected static ?string $model = ToDo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('ToDo Information')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->placeholder('Title')
                            ->required(),
                        
                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder('Description')
                            ->required(),
                        
                        Select::make('category_id')
                            ->label('Category')
                            ->placeholder('Category')
                            ->options(
                                \App\Models\Category::all()->pluck('name', 'id')
                            )
                            ->searchable()
                            ->required(),
                        
                        Select::make('user_id')
                            ->label('User')
                            ->placeholder('User')
                            ->options(
                                \App\Models\User::all()->pluck('name', 'id')
                            )
                            ->searchable()
                            ->required(),
                        
                        DateTimePicker::make('due_date')
                            ->label('Due Date')
                            ->required()
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->label('Title'),
                TextColumn::make('description')
                    ->searchable(),

                TextColumn::make('category.name')
                    ->searchable()
                    ->label('Category'),
                
                TextColumn::make('user.name')
                    ->searchable()
                    ->label('User'),
                
                TextColumn::make('due_date')
                    ->searchable()
                    ->label('Due Date'),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListToDos::route('/'),
            'create' => Pages\CreateToDo::route('/create'),
            'edit' => Pages\EditToDo::route('/{record}/edit'),
        ];
    }
}
