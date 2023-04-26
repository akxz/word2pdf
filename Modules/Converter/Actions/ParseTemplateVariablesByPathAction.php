<?php

namespace Modules\Converter\Actions;

class ParseTemplateVariablesByPathAction
{
    public function run($path)
    {
        $template = new \PhpOffice\PhpWord\TemplateProcessor($path);

        return $template->getVariables();
    }
}
