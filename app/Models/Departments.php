<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Departments extends Model
{
    use HasFactory, SoftDeletes, Userstamps;

    const CREATED_BY = 'CreatedBy';

    const UPDATED_BY = 'ModifiedBy';

    const DELETED_BY = 'DeletedBy';

    protected $fillable = [
        'DepartmentName',
        'ParentDepartment',
        'CreatedBy',
        'ModifiedBy',
        'DeletedBy',
    ];

    public function users(): BelongsToMany
{
    return $this->belongsToMany(User::class, 'user_departments', 'department_id', 'user_id');
}

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'CreatedBy');
    }

    public function jobOpenings(): HasMany
    {
        return $this->hasMany(JobOpenings::class, 'Department', 'id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachments::class, 'attachmentOwner', 'id');
    }
}
