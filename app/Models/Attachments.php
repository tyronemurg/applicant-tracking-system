<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachments extends Model
{
    protected $fillable = [
        'attachment',
        'attachmentName',
        'category',
        'attachmentOwner',
        'moduleName',
    ];

    public function jobCandidate(): BelongsTo
    {
        return $this->belongsTo(JobCandidates::class, 'attachmentOwner');
    }
}
