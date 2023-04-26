<?php

namespace Modules\Converter\Tasks;

class CreateDocxByTemplatePathAndValuesTask
{
    public function run($path, $data)
    {
        $template = new \PhpOffice\PhpWord\TemplateProcessor($path);
        $keys = $template->getVariables();

        if (count($keys) > 0) {
            foreach ($keys as $key) {
                $template->setValue($key, $data[$key] ?? '');
            }
        }

        $docxPath = storage_path('app/temp/docs/' . time() . '.docx');
        $template->saveAs($docxPath);

        return $docxPath;
    }
}
