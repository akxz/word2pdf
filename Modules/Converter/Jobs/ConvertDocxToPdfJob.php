<?php

namespace Modules\Converter\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Log;

class ConvertDocxToPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $filename;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $docxPath = storage_path(config('converter.docx_dir') . $this->filename . '.docx');
        $pdfDir = public_path('storage/temp/pdf/');

        $process = new Process([
            'libreoffice',
            '--headless',
            '--convert-to',
            'pdf:writer_pdf_Export',
            $docxPath,
            $pdfDir
        ]);

        try {
            $process->mustRun();
            Log::debug($process->getOutput());
        } catch (ProcessFailedException $exception) {
            Log::debug($exception->getMessage());
        }
    }
}
