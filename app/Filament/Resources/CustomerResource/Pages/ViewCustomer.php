<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;

class ViewCustomer extends ViewRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('publish')
                ->color('warning')
                ->icon('heroicon-o-arrow-uturn-up')
                ->tooltip('Publish this customer')
                ->label('Publish')
                ->hidden(fn (Model $record) => $record->published_career_site === 1 ?? false)
                ->action(function (Model $record) {
                    $record->published_career_site = 1;
                    $record->save();
                    Notification::make()
                        ->body('Customer has been published.')
                        ->success()
                        ->send();
                }),
            Action::make('unpublished')
                ->color('warning')
                ->icon('heroicon-o-arrow-uturn-left')
                ->tooltip('Unpublish this customer')
                ->label('Unpublish')
                ->requiresConfirmation()
                ->hidden(fn (Model $record) => $record->published_career_site === 0 ?? false)
                ->action(function (Model $record) {
                    $record->published_career_site = 0;
                    $record->save();
                    Notification::make()
                        ->body('Customer has been unpublished.')
                        ->success()
                        ->send();
                }),
            EditAction::make()
                ->icon('heroicon-o-pencil-square'),
            DeleteAction::make()
                ->icon('heroicon-o-trash'),
        ];
    }

}
