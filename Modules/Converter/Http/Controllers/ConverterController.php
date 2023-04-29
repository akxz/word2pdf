<?php

namespace Modules\Converter\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Converter\Http\Requests\UploadTemplateRequest;
use Modules\Converter\Http\Requests\GeneratePdfRequest;
use Modules\Converter\Actions\UploadTemplateAction;
use Modules\Converter\Actions\GeneratePdfAction;

class ConverterController extends Controller
{
    public function upload(UploadTemplateRequest $request)
    {
        $templateInfo = app(UploadTemplateAction::class)
            ->run($request->file('file'));

        return response()->json(compact('templateInfo'));
    }

    public function generatePdf(GeneratePdfRequest $request)
    {
        $filename = app(GeneratePdfAction::class)
            ->run($request->all());

        return response()->json(compact('filename'));
    }

    public function checkPdfByName($name)
    {
        $relPath = config('converter.public_pdf_dir') . $name . '.pdf';
        $path = public_path($relPath);

        if (file_exists($path)) {
            $link = config('app.url') . '/' . $relPath;
        } else {
            $link = '';
        }

        return response()->json(compact('link'));
    }
}
