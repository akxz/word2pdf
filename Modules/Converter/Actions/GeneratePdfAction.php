<?php

namespace Modules\Converter\Actions;

use Modules\Converter\Tasks\CreateDocxByTemplateValuesTask;
use Modules\Converter\Jobs\ConvertDocxToPdfJob;
use Illuminate\Support\Str;

class GeneratePdfAction
{
    public function run($data)
    {
        $filename = $this->generateFilename();
        app(CreateDocxByTemplateValuesTask::class)->run($data, $filename);
        ConvertDocxToPdfJob::dispatch($filename);

        return $filename;
    }

    private function generateFilename()
    {
        $filename = Str::random(5) . '-' . time();

        return Str::of($filename)->lower();
    }
}
