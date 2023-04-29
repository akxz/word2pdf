<?php

namespace Modules\Converter\Tasks;

class CreateDocxByTemplateValuesTask
{
    public function run($data, $filename)
    {
        $tplPath = storage_path(
            'app/' . config('converter.template_dir') . $data['template']
        );
        $template = new \PhpOffice\PhpWord\TemplateProcessor($tplPath);
        $keys = $template->getVariables();

        if (count($keys) > 0) {
            foreach ($keys as $key) {
                $template->setValue($key, $data[$key] ?? '');
            }
        }

        $docxPath = storage_path(config('converter.docx_dir') . $filename . '.docx');
        $template->saveAs($docxPath);
    }
}
