<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use App\Models\JobCandidates;
use Illuminate\Support\Facades\Auth;

class ChartWidget extends LineChartWidget
{

    protected static ?int $sort = 6;

    protected static bool $isLazy = false;


    public function getHeading(): string
    {
        return 'Candidate Applications';
    }

    protected function getData(): array
    {
        $user = Auth::user();

        if ($user->hasRole('super_admin')) {
            // Super admin can see all candidates
            $candidates = JobCandidates::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        } else {
            // Admin can only see candidates related to their job openings
            $candidates = JobCandidates::whereHas('job', function ($query) use ($user) {
                $query->where('CreatedBy', $user->id);
            })
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        }

        // Extract dates and counts from the query result
        $dates = $candidates->pluck('date')->toArray();
        $counts = $candidates->pluck('count')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Candidates Applied',
                    'data' => $counts, // Use the count of candidates as data
                ],
            ],
            'labels' => $dates, // Use dates as labels
        ];
    }

    public function getColumnSpan(): int | string | array
    {
        return 1; // Assuming 2 columns layout, span across both columns
    }
}
