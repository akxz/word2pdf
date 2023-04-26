<?php

namespace Modules\Converter\Tasks;

class ConvertDocxToHtmlTask
{
    public function run($docxPath)
    {
        $content = \PhpOffice\PhpWord\IOFactory::load($docxPath);
        $htmlPath = storage_path('app/temp/html/' . time() . '.html');
        $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($content,'HTML');
        $htmlWriter->save($htmlPath);

        return $htmlPath;
    }
}
