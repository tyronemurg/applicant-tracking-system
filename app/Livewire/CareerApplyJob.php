<?php

namespace App\Livewire;

use AbanoubNassem\FilamentGRecaptchaField\Forms\Components\GRecaptcha;
use Afatmustafa\FilamentTurnstile\Forms\Components\Turnstile;
use App\Filament\Enums\JobCandidateStatus;
use App\Models\Candidates;
use App\Models\Attachments;
use App\Models\JobCandidates;
use App\Models\JobOpenings;
use DominionSolutions\FilamentCaptcha\Forms\Components\Captcha;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class CareerApplyJob extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;
    use WithFileUploads;

    public $attachment;

    public ?array $data = ['attachment' => null];

    public ?string $captcha = '';

    public string|null|JobOpenings $record = '';

    public static ?JobOpenings $jobDetails = null;

    public ?string $referenceNumber;

    public function mount($jobReferenceNumber)
    {
        // search for the job reference number, if not valid, redirect to all job
        $this->jobOpeningDetails($jobReferenceNumber);
        $this->referenceNumber = $jobReferenceNumber;

    }

    public function updated()
    {
        $this->jobOpeningDetails($this->referenceNumber);
    }

    private function jobOpeningDetails($reference): void
    {
        $this->record = JobOpenings::jobStillOpen()->where('JobOpeningSystemID', '=', $reference)->first();
        if (empty($this->record)) {
            // redirect back as the job opening is closed or tampered id or not existing
            Notification::make()
                ->title('Job Opening is already closed or doesn\'t exist.')
                ->icon('heroicon-o-x-circle')
                ->iconColor('warning')
                ->send();
            $this->redirectRoute('career.landing_page');
        }
    }

    public function create(): void
    {
        $data = $this->form->getState();

   
    //    if (!empty($data['attachment']) && $data['attachment'] instanceof \Illuminate\Http\UploadedFile) {

    //     $attachmentPath = $data['attachment']->store('JobCandidate-attachments', 'public');
    //      Attachments::create([
    //          'attachment' => $attachmentPath,
    //          'attachmentName' => $data['attachment']->getClientOriginalName(),
    //         'category' => 'Resume',
    //          'attachmentOwner' => $candidate->id,
    //        'moduleName' => 'JobCandidates',
    //     ]);
    // }


    
        // Create Candidate
        $candidate = Candidates::create([
            'FirstName' => $data['FirstName'],
            'LastName' => $data['LastName'],
            'Mobile' => $data['mobile'],
            'email' => $data['Email'],
            'ExperienceInYears' => $data['experience'],
            'Street' => $data['Street'],
            'City' => $data['City'],
            'Country' => $data['Country'],
            'ZipCode' => $data['ZipCode'],
            'State' => $data['State'],
            'CurrentEmployer' => $data['CurrentEmployer'],
            'CurrentJobTitle' => $data['CurrentJobTitle'],
            'School' => $data['School'],
            'ExperienceDetails' => $data['ExperienceDetails'],
            'authorized_to_work' => $data['authorized_to_work'],
            'willing_to_travel' => $data['willing_to_travel'],
            'current_salary' => $data['current_salary'],
            'salary_expectations' => $data['salary_expectations'],
            'notice_period' => $data['notice_period'],
        ]);
    
        // Job Candidates
        $job_candidates = JobCandidates::create([
            'JobId' => $this->record->id,
            'CandidateSource' => 'Career Page',
            'CandidateStatus' => JobCandidateStatus::New,
            'candidate' => $candidate->id,
            'mobile' => $data['mobile'],
            'Email' => $data['Email'],
            'ExperienceInYears' => $data['experience'],
            'CurrentJobTitle' => $data['CurrentJobTitle'],
            'CurrentEmployer' => $data['CurrentEmployer'],
            'Street' => $data['Street'],
            'City' => $data['City'],
            'Country' => $data['Country'],
            'ZipCode' => $data['ZipCode'],
            'State' => $data['State'],
            'authorized_to_work' => $data['authorized_to_work'],
            'willing_to_travel' => $data['willing_to_travel'],
            'current_salary' => $data['current_salary'],
            'salary_expectations' => $data['salary_expectations'],
            'notice_period' => $data['notice_period'],
        ]);

             // Handle file upload manually
           //  dd($this->attachment);
     if ($this->attachment instanceof \Illuminate\Http\UploadedFile) {
        $attachmentPath = $this->attachment->store('JobCandidate-attachments', 'public');
       $attachment = Attachments::create([
            'attachment' => $attachmentPath,
            'attachmentName' => $this->attachment->getClientOriginalName(),
            'category' => 'Resume',
            'attachmentOwner' => $job_candidates->id,
            'moduleName' => 'JobCandidates',
        ]);
        //dd($attachment);
        
    } else {
        dd('Not insatnce of upload file');
    }

 
    
        if ($candidate && $job_candidates) {
            Notification::make()
                ->title('Application submitted!')
                ->success()
                ->body('Thank you for submitting your application details.')
                ->send();
            Notification::make()
                ->title('Reminder!')
                ->success()
                ->body('Please always check your communication for our hiring party response.')
                ->send();
            $this->redirectRoute('career.landing_page');
        }
    }
    

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Application')
                        ->icon('heroicon-o-user')
                        ->columns(2)
                        ->schema(array_merge($this->applicationStepWizard(),
                            // [Forms\Components\Grid::make(1)
                            //     ->columns(1)
                            //     ->schema($this->captchaField())]
                        )),
                    Wizard\Step::make('Assessment')
                        ->visible(false)
                        ->icon('heroicon-o-user')
                        ->columns(2)
                        ->schema(array_merge([], $this->assessmentStepWizard())),
                ])
                    ->nextAction(
                        fn (Action $action) => $action->view('career-form.apply-job-components.NextActionButton'),
                    )
                    ->submitAction(view('career-form.apply-job-components.SubmitApplicationButton')),
            ]);
    }

    private function assessmentStepWizard(): Wizard\Step|array
    {
        return [];
    }

    private function applicationStepWizard(): array
{
    return [
        Forms\Components\Section::make('Basic Information')
            ->columns(2)
            ->schema([
                Forms\Components\TextInput::make('FirstName')
                    ->required()
                    ->label('First Name'),
                Forms\Components\TextInput::make('LastName')
                    ->required()
                    ->label('Last Name'),
                Forms\Components\TextInput::make('mobile')
                    ->required(),
                Forms\Components\TextInput::make('Email')
                    ->required()
                    ->email(),
            ]),
        Forms\Components\Section::make('Address Information')
            ->columns(2)
            ->schema([
                Forms\Components\TextInput::make('Street'),
                Forms\Components\TextInput::make('City'),
                Forms\Components\TextInput::make('Country'),
                Forms\Components\TextInput::make('ZipCode'),
                Forms\Components\TextInput::make('State'),
            ]),
        Forms\Components\Section::make('Professional Details')
            ->columns(2)
            ->schema([
                Forms\Components\TextInput::make('CurrentEmployer')
                    ->label('Current Employer (Company Name)'),
                Forms\Components\TextInput::make('CurrentJobTitle')
                    ->label('Current Job Title'),
                Forms\Components\Select::make('experience')
                    ->options([
                        '1year' => '1year',
                        '2year' => '2 Years',
                        '3year' => '3 Years',
                        '4year' => '4 Years',
                        '5year' => '5 Years',
                        '6year' => '6 Years',
                        '7year' => '7 Years',
                        '8year' => '8 Years',
                        '9year' => '9 Years',
                        '10year+' => '10 Years & Above',
                    ])
                    ->label('Experience'),
            ]),
        Forms\Components\Section::make('Additional Information')
            ->columns(2)
            ->schema([
                Forms\Components\Select::make('authorized_to_work')
                    ->options([
                        'yes' => 'Yes',
                        'no' => 'No',
                    ])
                    ->label('Are you legally authorized to work in South Africa?')
                    ->required(),
                Forms\Components\Select::make('willing_to_travel')
                    ->options([
                        'yes' => 'Yes',
                        'no' => 'No',
                    ])
                    ->label('Are you willing to travel for work if required?')
                    ->required(),
                Forms\Components\TextInput::make('current_salary')
                    ->label('What is your current salary or monthly income (before tax or any deductions)?')
                    ->required(),
                Forms\Components\TextInput::make('salary_expectations')
                    ->label('What are your salary expectations?')
                    ->required(),
                Forms\Components\TextInput::make('notice_period')
                    ->label('What is your notice period?')
                    ->required(),
            ]),
        Forms\Components\Section::make('Educational Details')
            ->schema([
                Forms\Components\Repeater::make('School')
                    ->label('')
                    ->addActionLabel('+ Add Degree Information')
                    ->schema([
                        Forms\Components\TextInput::make('school_name')
                            ->required(),
                        Forms\Components\TextInput::make('major')
                            ->required(),
                        Forms\Components\Select::make('duration')
                            ->options([
                                '4years' => '4 Years',
                                '5years' => '5 Years',
                            ])
                            ->required(),
                        Forms\Components\Checkbox::make('pursuing')
                            ->inline(false),
                    ])
                    ->deletable(true)
                    ->columns(4),
            ]),
        Forms\Components\Section::make('Experience Details')
            ->schema([
                Forms\Components\Repeater::make('ExperienceDetails')
                    ->label('')
                    ->addActionLabel('Add Experience Details')
                    ->schema([
                        Forms\Components\Checkbox::make('current')
                            ->label('Current?')
                            ->inline(false),
                        Forms\Components\TextInput::make('company_name'),
                        Forms\Components\TextInput::make('duration'),
                        Forms\Components\TextInput::make('role'),
                        Forms\Components\Textarea::make('company_address'),
                    ])
                    ->deletable(true)
                    ->columns(5),
            ]),
        // Forms\Components\FileUpload::make('attachment')
        //     ->preserveFilenames()
        //     ->directory('JobCandidate-attachments')
        //     ->visibility('private')
        //     ->openable()
        //     ->downloadable()
        //     ->previewable()
        //     ->acceptedFileTypes([
        //         'application/pdf',
        //     ])
        //    // ->required()
        //     ->label('Resume'),
    ];
}


    // private function captchaField(): array
    // {
    //     if (! config('recruit.enable_captcha')) {
    //         return [];
    //     }
    //     if (config('recruit.enable_captcha')) {
    //         if (config('recruit.captcha_provider.default') === 'Google') {
    //             return [GRecaptcha::make('captcha')];
    //         }
    //         if (config('recruit.captcha_provider.default') === 'Cloudflare') {
    //             return [
    //                 Turnstile::make('turnstile')
    //                     ->theme('light')
    //                     ->size('normal')
    //                     ->language('en-US'),
    //             ];
    //         }

    //         // default
    //         if (config('recruit.captcha_provider.default') === 'Recruit_Captcha') {
    //             return [
    //                 Captcha::make('captcha')
    //                     ->rules(['captcha'])
    //                     //->required()
    //                     ->validationMessages([
    //                         'captcha' => __('Captcha does not match the image'),
    //                     ]),
    //             ];
    //         }

    //     }

    //     return [];

    // }

    #[Title('Apply Job ')]
    public function render()
    {
        return view('livewire.career-apply-job', [
            'jobDetail' => $this->record,
        ]);
    }
}
