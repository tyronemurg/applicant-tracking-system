<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Page;
use Filament\Facades\Filament;
use Filament\Support\Facades\FilamentIcon;
use App\Models\Candidates;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use App\Filament\Widgets\CandidateCountWidget;
use App\Filament\Widgets\ChartWidget;

class Dashboard extends Page
{
    protected static string $routePath = '/';

    protected static ?int $navigationSort = -2;

    /**
     * @var view-string
     */
    protected static string $view = 'filament.pages.dashboard';



    // public $candidates;

    // public function mount()
    // {
    //     $candidates = Candidates::all();
    //     //dd($this->candidates);
    //     return view('filament.pages.dashboard', [
    //         'candidates' => $candidates,
    //     ]);
    // }

    // public function render(): View
    // {
    //     return view('filament.pages.dashboard', [
    //         'candidates' => $this->candidates,
    //     ]);
    // }

    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ??
            static::$title ??
            __('filament-panels::pages/dashboard.title');
    }

    public static function getNavigationIcon(): string | Htmlable | null
    {
        return static::$navigationIcon
            ?? FilamentIcon::resolve('panels::pages.dashboard.navigation-item')
            ?? (Filament::hasTopNavigation() ? 'heroicon-m-home' : 'heroicon-o-home');
    }

    public static function getRoutePath(): string
    {
        return static::$routePath;
    }

    /**
     * @return array<class-string<Widget> | WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        return Filament::getWidgets();
    }

    /**
     * @return array<class-string<Widget> | WidgetConfiguration>
     */
    public function getVisibleWidgets(): array
    {
        return $this->filterVisibleWidgets($this->getWidgets());
    }

    /**
     * @return int | string | array<string, int | string | null>
     */
    public function getColumns(): int | string | array
    {
        return 2;
    }

    // public function getWidgetColumnSpan($widget): int
    // {
    //     if ($widget instanceof ChartWidget) {
    //         return 2; // Full width
    //     }

    //     return 1; // Default width
    // }

    public function getTitle(): string | Htmlable
    {
        return static::$title ?? __('filament-panels::pages/dashboard.title');
    }
}


