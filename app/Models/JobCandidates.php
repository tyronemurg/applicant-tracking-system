<?php

namespace App\Models;

use Alfa6661\AutoNumber\AutoNumberTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class JobCandidates extends Model
{
    use AutoNumberTrait, HasFactory, SoftDeletes, Userstamps;

    const CREATED_BY = 'CreatedBy';

    const UPDATED_BY = 'ModifiedBy';

    const DELETED_BY = 'DeletedBy';

    protected $fillable = [
        'JobCandidateId',
        'JobId',
        'candidate',
        'mobile',
        'Email',
        'ExperienceInYears',
        'CurrentJobTitle',
        'ExpectedSalary',
        'SkillSet',
        'HighestQualificationHeld',
        'CurrentEmployer',
        'CurrentSalary',
        'Street',
        'City',
        'Country',
        'ZipCode',
        'State',
        'CandidateStatus',
        'CandidateSource',
        'CandidateOwner',
        'ExperienceDetails',
        'authorized_to_work',
        'willing_to_travel',
        'current_salary',
        'salary_expectations',
        'notice_period',
        'CreatedBy',
        'ModifiedBy',
        'DeletedBy',
    ];

    protected $casts = [
        'SkillSet' => 'array',
    ];

    public function candidateProfile(): BelongsTo
    {
        return $this->belongsTo(Candidates::class, 'candidate', 'id');
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(JobOpenings::class, 'JobId', 'id');
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'CreatedBy');
    }

    public function recordOwner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'CandidateOwner', 'id');
    }

    protected $with = ['attachments'];

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachments::class, 'attachmentOwner', 'id');
    }

    /**
     * @return array[]
     */
    public function getAutoNumberOptions(): array
    {
        return [
            'JobCandidateId' => [
                'format' => 'RLR_?_JOBCAND', // autonumber format. '?' will be replaced with the generated number.
                'length' => 5, // The number of digits in an autonumber
            ],
        ];
    }
}
