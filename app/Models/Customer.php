<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fullName',
        'campaignName',
        'fullDescription',
        'completionLevel',
        'lastActivity',
        'prospectUuid',
        'status',
        'profileUrl',
        'profilePhoto',
        'uniqueLinkedinId',
        'firstName',
        'lastName',
        'jobTitle',
        'companyName',
        'emailId',
        'phoneNumber',
        'location',
        'companyWebsiteFromPersonalProfile',
        'personalWebsite',
        'linkedinSalesNavUrl',
        'linkedinUrl',
        'companyWebsiteFromCompanyProfile',
        'industry',
        'possiblePersonalisedLines',
        'randomlyChosenLine',
        'blackListed',
        'lastExecutionTime',
        'contactInfoCollectedAt',
        'tagList',
        'messageThreadId',
        'isUnread',
        'replySequenceEnabled',
        'sequenceComplete',
        'isPremium',
        'sentAsInMail',
        'mappedCustomStringFields',
        'topVolunteerExperience',
        'topRecommender',
        'topCertification',
        'mostRecentJobDuration',
        'topSkillEndorsementCount',
        'topSkill',
        'linkedinEmailId',
        'sentUsingEmail',
        'groupMessageAccepted',
        'inMailRejected',
        'failureReason',
        'failedSteps',
        'campaignStatus',
        'linkedinAccountUuid',
    ];

    protected $casts = [
        'possiblePersonalisedLines' => 'array',
        'tagList' => 'array',
        'failedSteps' => 'array',
    ];
}
