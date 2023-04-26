<?php

namespace Modules\Converter\Tasks;

class GetDocxTemplatePathByNameTask
{
    public function run($name)
    {
        $directory = config('converter.template_directory');

        return storage_path('app/' . $directory . '/' . $name);
    }
}
