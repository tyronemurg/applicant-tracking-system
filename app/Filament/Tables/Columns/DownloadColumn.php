<?php
// app/Filament/Tables/Columns/DownloadColumn.php

namespace App\Filament\Tables\Columns;

use App\Filament\Tables\Column;

class DownloadColumn extends Column
{
    protected function getAttachmentUrl($record)
    {
        $attachment = $record->attachments->first(); // Assuming a candidate has only one attachment

        if ($attachment) {
            return storage_path('app/' . $attachment->attachment); // Assuming the attachments are stored in the storage directory
        }

        return null;
    }

    public function downloadUrl($record)
    {
        $url = $this->getAttachmentUrl($record);

        if ($url) {
            return route('download.attachment', ['url' => $url]); // Define a route to handle attachment downloads
        }

        return null;
    }

    public function render($record)
    {
        $url = $this->downloadUrl($record);

        if ($url) {
            return "<a href='{$url}' target='_blank'>Download CV</a>";
        }

        return '-';
    }
}
