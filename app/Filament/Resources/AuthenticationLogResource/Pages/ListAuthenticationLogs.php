<?php

namespace Tapp\FilamentAuthenticationLog\Resources\AuthenticationLogResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Gate;
use Tapp\FilamentAuthenticationLog\Resources\AuthenticationLogResource;
use Illuminate\Database\Eloquent\Builder;

class ListAuthenticationLogs extends ListRecords
{
    protected function getTableQuery(): Builder
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {
            return AuthenticationLogResource::getEloquentQuery();
        } else {
            abort(403);
        }
    }

    public static function getResource(): string
    {
        return config('filament-authentication-log.resources.AutenticationLogResource', AuthenticationLogResource::class);
    }

    protected function canView(): bool
    {
        return Gate::allows('viewAny', AuthenticationLog::class);
    }
}
