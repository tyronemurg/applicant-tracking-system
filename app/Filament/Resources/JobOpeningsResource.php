<?php

namespace App\Filament\Resources;

use App\Filament\Enums\JobOpeningStatus;
use App\Filament\Resources\JobOpeningsResource\Pages;
use App\Filament\Resources\JobOpeningsResource\RelationManagers;
use App\Models\Departments;
use App\Models\JobOpenings;
use App\Models\User;
use App\Settings\JobOpeningSettings;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon; 
use Illuminate\Support\Facades\URL;


class JobOpeningsResource extends Resource
{
    protected static ?string $model = JobOpenings::class;

    protected static ?string $slug = 'job-openings';

    protected static ?string $recordTitleAttribute = 'postingTitle';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static array $requiredSkills = [];

    public function mount(JobOpeningSettings $setting): void
    {
        self::$requiredSkills = $setting->requiredSkills;
        parent::mount();

    }

    public static function form(Form $form): Form
    {

        $user = Auth::user();
     

        if ($user->hasRole('admin')) {
            // Retrieve the departments created by the admin
            $departmentOptions = Departments::where('CreatedBy', $user->id)
                ->pluck('DepartmentName', 'id');
        } else {
            // Super admin can see all departments
            $departmentOptions = Departments::all()->pluck('DepartmentName', 'id');
        }
        return $form
            ->schema([
                Section::make('Job Opening Information')
                    ->icon('heroicon-o-briefcase')
                    ->schema([
                        TextInput::make('postingTitle')
                            ->maxLength(225)
                            ->required(),
                        TextInput::make('NumberOfPosition')
                            ->numeric()
                            ->required(),
                        TextInput::make('JobTitle')
                            ->maxLength(225)
                            ->required(),
                        TextInput::make('JobOpeningSystemID')
                            ->label('Job Opening Unique Key ID')
                            ->readOnly()
                            ->hiddenOn('create'),
                            // Job URL using placeholder to show the structure
                TextInput::make('JobURL')
                ->label('Job URL')
                ->readonly() // Make it read-only
                ->placeholder(URL::to('/career/job/apply/')) // Base URL

                // Set the value dynamically in the view or controller
                ->afterStateHydrated(function ($component, $state) {
                    $jobOpeningId = $component->getRecord()->JobOpeningSystemID ?? '';
                    if ($jobOpeningId) {
                        // Using URL helper to build the full URL dynamically with the correct slash
                        $baseUrl = URL::to('/career/job/apply/');
                        $component->state($baseUrl . '/' . $jobOpeningId); // Add a slash before appending the ID
                    }
                }),
                        DatePicker::make('TargetDate')
                            ->label('Target Date')
                            ->format('d/m/Y')
                            ->native(false)
                            ->displayFormat('m/d/Y')
                            ->required(),
                        Select::make('Status')
                            ->options(JobOpeningStatus::class)
                            ->hiddenOn('create')
                            ->native(false)
                            ->default('New')
                            ->required(),
                        TextInput::make('Salary'),
                        Select::make('Department')
                            ->options($departmentOptions)
                            ->required(),
                        // Select::make('HiringManager')
                        //     ->options(User::all()->pluck('name', 'id')),
                        // Select::make('AssignedRecruiters')
                        //     ->options(User::all()->pluck('name', 'id')),
                        DatePicker::make('DateOpened')
                            ->label('Date Opened')
                            ->format('d/m/Y')
                            ->native(false)
                            ->displayFormat('m/d/Y')
                            ->required(),
                        Select::make('JobType')
                            ->options(config('recruit.job_opening.job_type_options'))
                            ->required(),
                        // Select::make('RequiredSkill')
                        //     ->multiple()
                        //     ->options(self::$requiredSkills),
                            //->required(),
                        Select::make('WorkExperience')
                            ->options(config('recruit.job_opening.work_experience'))
                            ->required(),
                        Checkbox::make('RemoteJob')
                            ->inline(false)
                            ->default(false),
                    ])->columns(2),
                Section::make('Address Information')
                    ->id('job-opening-address-information-section')
                    ->icon('heroicon-o-map')
                    ->schema([
                        TextInput::make('City')
                            ->required(),
                        TextInput::make('Country')
                            ->required(),
                        TextInput::make('State')
                            ->label('State/Province')
                            ->required(),
                        TextInput::make('ZipCode')
                            ->label('Zip/Postal Code')
                            ->required(),
                    ])->columns(2),
                Section::make('Description Information')
                    ->id('job-opening-description-information')
                    ->icon('heroicon-o-briefcase')
                    ->label('Description Information')
                    ->schema([
                        Textarea::make('JobDescription')
                        ->label('Job Description')
                        ->required()
                        ->rows(4),
                        Textarea::make('JobRequirement')
                                    ->label('Requirements')
                                   // ->required(),
                                   ->rows(4),
                                   Textarea::make('JobBenefits')
                                    ->label('Benefits')
                                    ->rows(4),
                                  //  ->required(),
                                  Textarea::make('AdditionalNotes')
                                    ->hintIcon('heroicon-o-information-circle', tooltip: 'This field will display in the career job portal')
                                    ->label('Additional Notes')
                                    ->nullable()
                                    ->rows(4),
                    ])->columns(1),
                Section::make('System Information')
                    ->hiddenOn(['create', 'edit'])
                    ->id('job-opening-system-info')
                    ->icon('heroicon-o-computer-desktop')
                    ->label('System Information')
                    ->schema([
                        TextInput::make('CreatedBy'),
                        TextInput::make('ModifiedBy'),
                        TextInput::make('created_at')
                            ->label('Created Date'),
                        TextInput::make('updated_at')
                            ->label('Last Modified Date'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('postingTitle')
                    ->label('Job Title Name'),
                TextColumn::make('NumberOfPosition')
                    ->label('# of Vacancy'),
                TextColumn::make('TargetDate')
                    ->label('Target Date'),
                TextColumn::make('DateOpened')
                    ->label('Date Opened'),
                TextColumn::make('JobType')
                    ->label('Job Type'),
                IconColumn::make('RemoteJob')
                    ->label('Remote')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge'),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-m-plus-small'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('download_csv') // New action for CSV download
                    ->label('Download CSV')
                    ->icon('heroicon-o-check-badge')
                    ->action(function (JobOpenings $record) {
                        return new StreamedResponse(function () use ($record) {
                            $handle = fopen('php://output', 'w');
            
                            // Add CSV headers, including Job Description
                            fputcsv($handle, [
                                'Posting Title',
                                'Number of Position',
                                'Job Title',
                                'Target Date',
                                'Date Opened',
                                'Job Type',
                                'Remote Job',
                                'Job Description', // New column for Job Description
                            ]);
            
                            // Convert date fields to Carbon instances using the correct format
                            $targetDate = Carbon::createFromFormat('d/m/Y', $record->TargetDate);
                            $dateOpened = Carbon::createFromFormat('d/m/Y', $record->DateOpened);
            
                            // Add job opening data, including Job Description
                            fputcsv($handle, [
                                $record->postingTitle,
                                $record->NumberOfPosition,
                                $record->JobTitle,
                                $targetDate->format('d/m/Y'), // Format the date as needed
                                $dateOpened->format('d/m/Y'),
                                $record->JobType,
                                $record->RemoteJob ? 'Yes' : 'No',
                                $record->JobDescription, // New entry for Job Description
                            ]);
            
                            fclose($handle);
                        }, 200, [
                            'Content-Type' => 'text/csv',
                            'Content-Disposition' => 'attachment; filename="' . $record->JobTitle . '_job_opening.csv"',
                        ]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('unpublished')
                        ->tooltip('Unpublished this opening job in the career page')
                        ->icon('heroicon-o-arrow-uturn-left')
                        ->label('Unpublished')
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion()
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->published_career_site = 0;
                                $record->save();
                            }
                            Notification::make()
                                ->body('Job Opening has been unpublished.')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\BulkAction::make('published')
                        ->label('Publish')
                        ->icon('heroicon-o-arrow-uturn-up')
                        ->tooltip('Publish this opening job to the career page')
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion()
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->published_career_site = 1;
                                $record->save();
                            }
                            Notification::make()
                                ->body('Job Opening has been published.')
                                ->success()
                                ->send();
                        }),
                ])
                    ->icon('heroicon-o-globe-alt')
                    ->label('Publish/Unpublished'),
                Tables\Actions\BulkAction::make('change_status')
                    ->label('Update Status')
                    ->icon('heroicon-o-pencil-square')
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion()
                    ->form([
                        Select::make('Status')
                            ->options(JobOpeningStatus::class)
                            ->native(false)
                            ->required(),
                    ])
                    ->action(function (Collection $records, array $data) {
                        foreach ($records as $record) {
                            $record->Status = $data['Status'];
                            $record->save();
                        }
                        Notification::make()
                            ->body("Job Opening status has been successfully updated to {$data['Status']}.")
                            ->success()
                            ->send();
                    }),

            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobOpenings::route('/'),
            'create' => Pages\CreateJobOpenings::route('/create'),
            'view' => Pages\ViewJobOpenings::route('/{record}'),
            'edit' => Pages\EditJobOpenings::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AttachmentsRelationManager::class,
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }

    
}
