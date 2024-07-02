<?php

//namespace App\Filament\Widgets;
namespace Filament\Widgets;
use App\Models\Candidates;
use Filament\Widgets\Widget;

class AccountWidget extends Widget
{
    protected static ?int $sort = 2;

    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = 'full';

    /**
     * @var view-string
     */
    protected static string $view = 'widgets.account-widget';
    // public $candidatesCount;
    // public function mount()
    // {
    //     $this->candidatesCount  = Candidates::count();
    //     //dd($candidatesCount );
    //     return view('widgets.account-widget', ['candidatesCount ' => $this->candidatesCount]);

    // }
    
  
}
