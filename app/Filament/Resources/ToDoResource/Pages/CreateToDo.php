<?php

namespace App\Filament\Resources\ToDoResource\Pages;

use App\Filament\Resources\ToDoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateToDo extends CreateRecord
{
    protected static string $resource = ToDoResource::class;
}
