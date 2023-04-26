<?php

namespace Modules\Converter\Tasks;

use MPDF;

class ConvertHtmlToPdfTask
{
    public function run($htmlPath)
    {
        $html = file_get_contents($htmlPath);
        $filename = 'document-' . time();
        $pdfPath = public_path('storage/temp/pdf/' . $filename . '.pdf');
        MPDF::loadHtml($html)->save($pdfPath);

        return $filename;
    }
}
