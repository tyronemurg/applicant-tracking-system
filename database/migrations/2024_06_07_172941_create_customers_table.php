<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('fullName')->nullable();
            $table->string('campaignName')->nullable();
            $table->text('fullDescription')->nullable();
            $table->string('completionLevel')->nullable();
            $table->timestamp('lastActivity')->nullable();
            $table->uuid('prospectUuid')->nullable();
            $table->string('status')->nullable();
            $table->string('profileUrl')->nullable();
            $table->string('profilePhoto')->nullable();
            $table->string('uniqueLinkedinId')->nullable();
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('jobTitle')->nullable();
            $table->string('companyName')->nullable();
            $table->string('emailId')->nullable();
            $table->string('phoneNumber')->nullable();
            $table->string('location')->nullable();
            $table->string('companyWebsiteFromPersonalProfile')->nullable();
            $table->string('personalWebsite')->nullable();
            $table->string('linkedinSalesNavUrl')->nullable();
            $table->string('linkedinUrl')->nullable();
            $table->string('companyWebsiteFromCompanyProfile')->nullable();
            $table->string('industry')->nullable();
            $table->text('possiblePersonalisedLines')->nullable();
            $table->text('randomlyChosenLine')->nullable();
            $table->boolean('blackListed')->default(false);
            $table->timestamp('lastExecutionTime')->nullable();
            $table->timestamp('contactInfoCollectedAt')->nullable();
            $table->text('tagList')->nullable();
            $table->string('messageThreadId')->nullable();
            $table->boolean('isUnread')->nullable();
            $table->boolean('replySequenceEnabled')->nullable();
            $table->boolean('sequenceComplete')->nullable();
            $table->boolean('isPremium')->default(true);
            $table->boolean('sentAsInMail')->nullable();
            $table->json('mappedCustomStringFields')->nullable();
            $table->string('topVolunteerExperience')->nullable();
            $table->string('topRecommender')->nullable();
            $table->string('topCertification')->nullable();
            $table->string('mostRecentJobDuration')->nullable();
            $table->integer('topSkillEndorsementCount')->nullable();
            $table->string('topSkill')->nullable();
            $table->string('linkedinEmailId')->nullable();
            $table->boolean('sentUsingEmail')->nullable();
            $table->boolean('groupMessageAccepted')->nullable();
            $table->boolean('inMailRejected')->nullable();
            $table->string('failureReason')->nullable();
            $table->json('failedSteps')->nullable();
            $table->string('campaignStatus')->nullable();
            $table->uuid('linkedinAccountUuid')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
