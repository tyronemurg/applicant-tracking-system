<?php

namespace App\Filament\Resources\SpatieRoleResource\Pages;

use App\Filament\Resources\SpatieRoleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListRoles extends ListRecords
{
    protected static string $resource = SpatieRoleResource::class;

    protected function getTableQuery(): Builder
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {
            return SpatieRoleResource::getEloquentQuery();
        } else {
            abort(403);
        }
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
