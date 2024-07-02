<?php

namespace BezhanSalleh\FilamentShield\Resources\RoleResource\Pages;

use BezhanSalleh\FilamentShield\Resources\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    protected function getTableQuery(): Builder
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {
            return RoleResource::getEloquentQuery();
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
