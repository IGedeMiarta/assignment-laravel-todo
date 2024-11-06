<?php

namespace App\Filament\Resources\ToDoResource\Pages;

use App\Filament\Resources\ToDoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListToDos extends ListRecords
{
    protected static string $resource = ToDoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
