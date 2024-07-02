<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\JobOpenings;
use Illuminate\Support\Facades\Auth;

class JobOpeningsWidget extends Widget
{
    protected static ?int $sort = 5;

    protected static bool $isLazy = false;

    protected static string $view = 'widgets.job-openings-widget';

    public $jobOpeningsCount;

    public function mount(): void
    {
        $user = Auth::user();

        if ($user->hasRole('super_admin')) {
            // Super admin can see all job openings
            $this->jobOpeningsCount = JobOpenings::count();
        } else {
            // Admin can only see the job openings they created
            $this->jobOpeningsCount = JobOpenings::where('CreatedBy', $user->id)->count();
        }
    }
}
