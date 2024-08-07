<?php

namespace App\Filament\Pages;

abstract class SimplePage extends BasePage
{
    use Concerns\HasMaxWidth;
    use Concerns\HasTopbar;

    protected static string $layout = 'filament.components.layout.simple';

    protected function getLayoutData(): array
    {
        return [
            'hasTopbar' => $this->hasTopbar(),
            'maxWidth' => $this->getMaxWidth(),
        ];
    }

    public function hasLogo(): bool
    {
        return true;
    }
}
