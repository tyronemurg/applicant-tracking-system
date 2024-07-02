<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\JobCandidates;
use Illuminate\Support\Facades\Auth;

class CandidateCountWidget extends Widget
{
    protected static ?int $sort = 4;

    protected static bool $isLazy = false;

    protected static string $view = 'widgets.candidate-counter-widget';

    public $candidatesCount;

    public function mount(): void
    {
        $user = Auth::user();

        if ($user->hasRole('super_admin')) {
            // Super admin can see all candidates
            $this->candidatesCount = JobCandidates::count();
        } else {
            // Admin can only see candidates for the job openings they created
            $this->candidatesCount = JobCandidates::whereHas('job', function ($query) use ($user) {
                $query->where('CreatedBy', $user->id);
            })->count();
        }
    }
}
