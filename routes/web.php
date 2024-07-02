<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidatesController;
use App\Http\Controllers\ProspectController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CsvDownloadController;
use App\Http\Controllers\AttachmentController;
use Illuminate\Support\Facades\Http;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/attachments/download', [AttachmentController::class, 'download'])->name('attachments.download');
Route::post('/download-csv', [CsvDownloadController::class, 'downloadCsv'])->name('download-csv');
Route::get('/candidates', [CandidatesController::class, 'index'])->name('candidates');
Route::get('/career', \App\Livewire\CareerLandingPage::class)->name('career.landing_page');
Route::get('/career/job-details/{jobReferenceNumber}', \App\Livewire\CareerJobDetail::class)->name('career.job_details');
Route::get('/career/job/apply/{jobReferenceNumber}', \App\Livewire\CareerApplyJob::class)->name('career.job_apply');

// Candidate Portal Invitation
Route::get('portal/invite/{id}', \App\Livewire\Portal\Invitation\CreateCandidateUser::class)->name('portal.invite');
Route::get('/invite/{id}', \App\Livewire\User\Invitation\CreateSystemUserForm::class)->name('system-user.invite');

//Route::get('/invite', function () {

//    $user = \App\Models\User::find(1);
//    $candidates = \App\Models\Candidates::find(1);
//    $candidates->notifyNow(new \App\Notifications\CandidatePortalInvitation($candidates));

//});
