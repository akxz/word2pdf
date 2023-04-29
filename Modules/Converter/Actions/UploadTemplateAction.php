<?php

namespace Modules\Converter\Actions;

use Modules\Converter\Tasks\ParseTemplateVariablesByPathTask;

class UploadTemplateAction
{
    public function run($file)
    {
        $directory = config('converter.template_dir');
        $path = $file->store($directory);
        $filename = str_replace($directory . '/', '', $path);
        $keys = app(ParseTemplateVariablesByPathTask::class)
            ->run(storage_path('app/' . $path));

        return [
            'name' => $filename,
            'labels' => $keys
        ];
    }
}
