<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class AttachmentController extends Controller
{
    public function download()
{
    try {
        $attachments = Attachments::all();
        $zip = new ZipArchive;
        $zipFileName = 'cvs.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            foreach ($attachments as $attachment) {
                $filePath = storage_path('app/public/' . $attachment->path);
                $relativeName = basename($filePath);
                $zip->addFile($filePath, $relativeName);
            }
            $zip->close();

            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } else {
            throw new \Exception("Failed to open zip file: " . $zip->getStatusString());
        }
    } catch (\Exception $e) {
        // Log or handle the error appropriately
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
