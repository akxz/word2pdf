<?php

namespace Modules\Converter\Actions;

use Modules\Converter\Tasks\GetDocxTemplatePathByNameTask;
use Modules\Converter\Tasks\CreateDocxByTemplatePathAndValuesTask;
use Modules\Converter\Tasks\ConvertDocxToHtmlTask;
use Modules\Converter\Tasks\ConvertHtmlToPdfTask;

class GeneratePdfAndGetDownloadUrlAction
{
    public function run($data)
    {
        $path = app(GetDocxTemplatePathByNameTask::class)
            ->run($data['template']);

        $docxPath = app(CreateDocxByTemplatePathAndValuesTask::class)
            ->run($path, $data);

        $htmlPath = app(ConvertDocxToHtmlTask::class)->run($docxPath);
        $pdfFilename = app(ConvertHtmlToPdfTask::class)->run($htmlPath);

        return config('app.url') . '/storage/temp/pdf/' . $pdfFilename . '.pdf';
    }
}
