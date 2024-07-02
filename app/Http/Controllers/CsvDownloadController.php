<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\JobCandidates;
use Illuminate\Support\Facades\Auth;

class CsvDownloadController extends Controller
{
    public function downloadCsv(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('super_admin')) {
            // Super admin can see all job candidates
            $jobCandidates = JobCandidates::all();
        } else {
            // Admin can only see job candidates for the job openings they created
            $jobCandidates = JobCandidates::whereHas('job', function ($query) use ($user) {
                $query->where('CreatedBy', $user->id);
            })->get();
        }

        // Define CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="candidates.csv"',
        ];

        // Initialize CSV data
        $csvData = "JobCandidateId,JobId,candidate,mobile,Email,ExperienceInYears,CurrentJobTitle,ExpectedSalary,SkillSet,HighestQualificationHeld,CurrentEmployer,CurrentSalary,Street,City,Country,ZipCode,State,CandidateStatus,CandidateSource,CandidateOwner,ExperienceDetails,authorized_to_work,willing_to_travel,current_salary,salary_expectations,notice_period,CreatedBy,ModifiedBy,DeletedBy\n";

        // Populate CSV data with job candidates information
        foreach ($jobCandidates as $candidate) {
            // Convert array values to strings
            $candidateData = $candidate->toArray();
            $rowData = [];
            foreach ($candidateData as $value) {
                if (is_array($value)) {
                    // Skip arrays
                    continue;
                }
                // Explicitly cast non-array values to string
                $rowData[] = (string) $value;
            }

            // Concatenate candidate properties to CSV data
            $csvData .= implode(',', $rowData) . "\n";
        }

        // Return CSV file as a response
        return Response::make($csvData, 200, $headers);
    }
}
