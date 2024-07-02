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
        Schema::table('candidates', function (Blueprint $table) {
            $table->string('authorized_to_work')->after('ExperienceDetails');
            $table->string('willing_to_travel')->after('authorized_to_work');
            $table->string('current_salary')->after('willing_to_travel');
            $table->string('salary_expectations')->after('current_salary');
            $table->string('notice_period')->after('salary_expectations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            //
        });
    }
};
