<?php

namespace App\Filament\Resources\JobCandidatesResource\Pages;

use App\Filament\Resources\JobCandidatesResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;

class ViewJobCandidates extends ViewRecord
{
    protected static string $resource = JobCandidatesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    // public function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             // Other form components...
    //             Section::make('Attachments')
    //                 ->schema([
    //                     FileUpload::make('attachments')
    //                         ->label('Attachments')
    //                         ->multiple()
    //                         ->preserveFilenames()
    //                         ->directory('JobCandidate-attachments')
    //                         ->visibility('private')
    //                         ->openable()
    //                         ->downloadable()
    //                         ->previewable()
    //                         ->acceptedFileTypes(['application/pdf']),
    //                 ]),
    //         ]);
    // }
}
