<?php

namespace App\Filament\Resources\DepartmentsResource\Pages;

use App\Filament\Resources\DepartmentsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Departments;

class ListDepartments extends ListRecords
{
    protected static string $resource = DepartmentsResource::class;

    protected function getTableQuery(): Builder
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {
            return Departments::query();
        } else {
            return Departments::where('CreatedBy', $user->id);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
