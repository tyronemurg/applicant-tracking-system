<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\JobCandidates;
use App\Models\JobOpenings;
use App\Models\Attachments;
use Illuminate\Support\Facades\Auth;

class StatsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected static bool $isLazy = false;

    public function getHeading(): string
    {
        return 'Candidate Applications';
    }

    protected function getStats(): array
    {
        $user = Auth::user();
        
        if ($user->hasRole('super_admin')) {
            // Super admin can see all records
            $newCandidatesCount = JobCandidates::where('CandidateStatus', 'New')->count();
            $newOpeningsCount = JobOpenings::where('Status', 'Opened')->count();
            $newAttachmentsCount = Attachments::count();
        } else {
            // Admin can see only their own records
            $newCandidatesCount = JobCandidates::whereHas('job', function($query) use ($user) {
                $query->where('CreatedBy', $user->id);
            })->where('CandidateStatus', 'New')->count();

            $newOpeningsCount = JobOpenings::where('Status', 'Opened')->where('CreatedBy', $user->id)->count();

            $newAttachmentsCount = Attachments::whereHas('jobCandidate', function($query) use ($user) {
                $query->whereHas('job', function($query) use ($user) {
                    $query->where('CreatedBy', $user->id);
                });
            })->count();
        }

        // Generate random chart data for demonstration purposes
        $chartData = collect(range(1, 7))->map(function () {
            return random_int(1, 20);
        });

        return [
            Stat::make('New Candidates', $newCandidatesCount)
                ->description('Total number of new candidates')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart($chartData->toArray())
                ->color('success'),
            Stat::make('Open Positions', $newOpeningsCount)
                ->description('Total number of open positions')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart($chartData->toArray())
                ->color('primary'),
            Stat::make('Latest CVs', $newAttachmentsCount)
                ->description('Total number of new CVs')
                ->descriptionIcon('heroicon-m-paper-clip')
                ->chart($chartData->toArray()) // You can use different chart data if needed
                ->color('danger')
        ];
    }

    public function getColumnSpan(): int | string | array
    {
        return 2; // Assuming 2 columns layout, span across both columns
    }
}
