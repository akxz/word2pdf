<?php

namespace Modules\Converter\Actions;

class UploadTemplateAction
{
    public function run($file)
    {
        $directory = config('converter.template_directory');
        $path = $file->store($directory);
        $filename = str_replace($directory . '/', '', $path);
        $keys = app(ParseTemplateVariablesByPathAction::class)
            ->run(storage_path('app/' . $path));

        return [
            'name' => $filename,
            'labels' => $keys
        ];
    }
}
