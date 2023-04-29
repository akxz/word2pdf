<?php

namespace Modules\Converter\Tasks;

class ParseTemplateVariablesByPathTask
{
    public function run($path)
    {
        $template = new \PhpOffice\PhpWord\TemplateProcessor($path);

        return $template->getVariables();
    }
}
