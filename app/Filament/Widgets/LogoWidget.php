<?php

namespace App\Filament\Widgets;
use Filament\Widgets\Widget;

class LogoWidget extends Widget
{
    protected static ?int $sort = 1;

    protected static bool $isLazy = false;

   

    /**
     * @var view-string
     */
    protected static string $view = 'widgets.logo-widget';

}
