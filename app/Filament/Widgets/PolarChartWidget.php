<?php

namespace App\Filament\Widgets;

use Filament\Widgets\PolarAreaChartWidget;
use App\Models\JobOpenings;
use Illuminate\Support\Facades\Auth;

class PolarChartWidget extends PolarAreaChartWidget
{

    protected static ?int $sort = 7;

    protected static bool $isLazy = false;


    public function getHeading(): string
    {
        return 'Positions open per Job Title';
    }

    protected function getData(): array
    {
        $user = Auth::user();

        if ($user->hasRole('super_admin')) {
            // Super admin can see all job openings
            $jobOpenings = JobOpenings::selectRaw('JobTitle as title, SUM(NumberOfPosition) as positions')
                ->groupBy('title')
                ->get();
        } else {
            // Admin can only see job openings created by them
            $jobOpenings = JobOpenings::where('CreatedBy', $user->id)
                ->selectRaw('JobTitle as title, SUM(NumberOfPosition) as positions')
                ->groupBy('title')
                ->get();
        }

        // Extract titles and positions from the query result
        $titles = $jobOpenings->pluck('title')->toArray();
        $positions = $jobOpenings->pluck('positions')->toArray();

        // Define a color palette with a sufficient number of colors
        $colorPalette = [
            'rgb(247, 120, 107)',
            'rgb(255, 184, 92)',
            'rgb(128, 216, 255)',
            'rgb(169, 206, 94)',
            'rgb(232, 142, 255)',
            'rgb(86, 191, 194)',
            'rgb(255, 151, 145)',
            'rgb(171, 171, 171)',
            'rgb(255, 241, 153)',
            'rgb(175, 238, 238)',
            'rgb(245, 166, 35)',
            'rgb(102, 217, 239)',
            'rgb(253, 180, 92)',
            'rgb(234, 133, 163)',
            'rgb(152, 215, 142)',
        ];

        // Assign colors to each section dynamically
        $colors = [];
        foreach ($positions as $index => $count) {
            // Use modulo operator to loop through the color palette
            $colorIndex = $index % count($colorPalette);
            $colors[] = $colorPalette[$colorIndex];
        }

        return [
            'labels' => $titles, // Use job titles as labels
            'datasets' => [
                [
                    'label' => 'Job Openings',
                    'data' => $positions, // Use the count of job openings as data
                    'backgroundColor' => $colors,
                ],
            ],
        ];
    }

    public function getColumnSpan(): int | string | array
    {
        return 1; // Assuming 2 columns layout, span across both columns
    }
}
