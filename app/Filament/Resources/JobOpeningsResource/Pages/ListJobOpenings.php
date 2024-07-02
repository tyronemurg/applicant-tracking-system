<?php

namespace App\Filament\Resources\JobOpeningsResource\Pages;

use App\Filament\Resources\JobOpeningsResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Models\JobOpenings;

class ListJobOpenings extends ListRecords
{
    protected static string $resource = JobOpeningsResource::class;

    protected function getTableQuery(): Builder
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {
            return JobOpenings::query();
        } else {
            return JobOpenings::where('CreatedBy', $user->id);
        }
    }

    protected function getActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-m-plus-small'),
        ];
    }
}
