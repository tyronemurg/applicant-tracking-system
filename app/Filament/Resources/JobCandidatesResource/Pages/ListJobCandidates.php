<?php

namespace App\Filament\Resources\JobCandidatesResource\Pages;

use App\Filament\Resources\JobCandidatesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Models\JobCandidates;

class ListJobCandidates extends ListRecords
{
    protected static string $resource = JobCandidatesResource::class;

    protected function getTableQuery(): Builder
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {
            return JobCandidates::query();
        } else {
            return JobCandidates::where('CreatedBy', $user->id);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
